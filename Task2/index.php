<?php
/**
 * Created by PhpStorm.
 * User: hovsep
 * Date: 03.02.19
 * Time: 22:01
 */

require_once 'bootstrap.php';

//Form submitted
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    try {

        //Read form
        $inputFields = ['localDay', 'localHour', 'carValue', 'tax', 'instalments'];
        $inputData = [];

        foreach ($inputFields as $field) {
            if (!array_key_exists($field, $_POST)) {
                throw new \Exception("$field is empty");
            }

            $inputData[$field] = $_POST[$field];
        }

        //Prevent division by zero
        if (empty($inputData['instalments']) || ($inputData['instalments'] < 0)) {
            $inputData['instalments'] = 1;
        }

        //Calculate price matrix
        $priceMatrix = [];

        $basePriceCalculator = (new BasePrice())->setDayAndHour($inputData['localDay'], $inputData['localHour']);

        $priceMatrix['basePrice'] = $basePriceCalculator->calculate($inputData['carValue']);
        $priceMatrix['basePriceMultiplier'] = $basePriceCalculator->getMultiplier();
        $priceMatrix['basePricePerInstalment'] = round($priceMatrix['basePrice'] / $inputData['instalments'], 2);

        $priceMatrix['commission'] = (new Commission())->calculate($priceMatrix['basePrice']);
        $priceMatrix['commissionMultiplier'] = Commission::MULTIPLIER;
        $priceMatrix['commissionPerInstalment'] = round($priceMatrix['commission'] / $inputData['instalments'], 2);

        $priceMatrix['tax'] = (new Tax($inputData['tax']))->calculate($priceMatrix['basePrice']);
        $priceMatrix['taxPerInstalment'] = round($priceMatrix['tax'] / $inputData['instalments'], 2);

        $priceMatrix['total'] = $priceMatrix['basePrice'] + $priceMatrix['commission'] + $priceMatrix['tax'];
        $priceMatrix['totalPerInstalment'] = round($priceMatrix['total'] / $inputData['instalments'], 2);
    } catch (\Exception $e) {
        throw new \Exception('Failed to read input. Reason: ' . $e->getMessage());
    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Welcome to basic insurance calculator</title>
</head>
<body>
<div class="container-fluid">
    <!-- Form !-->
    <div class="row justify-content-center">
        <div class="col-md-5 pt-5">
            <form method="POST" action="index.php">
                <input type="hidden" name="localDay" id="local-day">
                <input type="hidden" name="localHour" id="local-hour">

                <div class="form-group">
                    <label>
                        Estimated value of the car:
                    </label>
                    <input class="form-control" type="number" min="100" max="100000" name="carValue" required value="<?php echo isset($inputData['carValue']) ? $inputData['carValue'] : '' ?>">
                    <small class="form-text text-muted">
                        100 - 100 000 EUR
                    </small>
                </div>

                <div class="form-group">
                    <label>
                        Tax percentage:
                    </label>
                    <input class="form-control" type="number" min="0" max="100" name="tax" required value="<?php echo isset($inputData['tax']) ? $inputData['tax'] : '' ?>">
                    <small class="form-text text-muted">
                        0 - 100%
                    </small>
                </div>

                <div class="form-group">
                    <label>
                        Number of instalments:
                    </label>
                    <input class="form-control" type="number" min="1" max="12" name="instalments" required value="<?php echo isset($inputData['instalments']) ? $inputData['instalments'] : '' ?>">
                    <small class="form-text text-muted">
                        count of payments in which client wants to pay for the policy (1 – 12)
                    </small>
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-primary" type="submit">
                        Calculate
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if (('POST' == $_SERVER['REQUEST_METHOD']) && !empty($inputData) && !empty($priceMatrix)): ?>
        <!-- Price matrix !-->
        <div class="row justify-content-center p-3">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Policy</th>
                    <?php for($i = 1; $i <= $inputData['instalments']; $i++): ?>
                        <th>
                            <?php echo $i ?> installment
                        </th>
                    <?php endfor; ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        Value
                    </td>
                    <td class="text-right">
                        <?php Helpers::nf($inputData['carValue']) ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        Base premium (<?php echo $priceMatrix['basePriceMultiplier'] * 100 ?>%)
                    </td>
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['basePrice']) ?>
                    </td>

                    <?php for($i = 1; $i < $inputData['instalments']; $i++): ?>
                        <td class="text-right">
                            <?php Helpers::nf($priceMatrix['basePricePerInstalment']) ?>
                        </td>
                    <?php endfor; ?>

                    <!-- Last installment need to be checked !-->
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['basePrice'] - $priceMatrix['basePricePerInstalment'] * ($inputData['instalments'] - 1)) ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        Commission (<?php  echo $priceMatrix['commissionMultiplier'] * 100 ?>%)
                    </td>
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['commission']) ?>
                    </td>

                    <?php for($i = 1; $i < $inputData['instalments']; $i++): ?>
                        <td class="text-right">
                            <?php Helpers::nf($priceMatrix['commissionPerInstalment']) ?>
                        </td>
                    <?php endfor; ?>

                    <!-- Last installment need to be checked !-->
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['commission'] - $priceMatrix['commissionPerInstalment'] * ($inputData['instalments'] - 1)) ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        Tax (<?php  echo $inputData['tax'] ?>%)
                    </td>
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['tax']) ?>
                    </td>

                    <?php for($i = 1; $i < $inputData['instalments']; $i++): ?>
                        <td class="text-right">
                            <?php Helpers::nf($priceMatrix['taxPerInstalment']) ?>
                        </td>
                    <?php endfor; ?>

                    <!-- Last installment need to be checked !-->
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['tax'] - $priceMatrix['taxPerInstalment'] * ($inputData['instalments'] - 1)) ?>
                    </td>
                </tr>

                <tr class="font-weight-bold">
                    <td>
                        Total cost
                    </td>
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['total']) ?>
                    </td>

                    <?php for($i = 1; $i < $inputData['instalments']; $i++): ?>
                        <td class="text-right">
                            <?php Helpers::nf($priceMatrix['totalPerInstalment']) ?>
                        </td>
                    <?php endfor; ?>

                    <!-- Last installment need to be checked !-->
                    <td class="text-right">
                        <?php Helpers::nf($priceMatrix['total'] - $priceMatrix['totalPerInstalment'] * ($inputData['instalments'] - 1)) ?>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    <?php endif; ?>
<script type="text/javascript">
    var now = new Date();
    document.getElementById("local-day").value = now.getDay();
    document.getElementById("local-hour").value = now.getHours();
</script>
</div>
</body>
</html>
