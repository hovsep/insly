/*Our table is denormalized, so all i18n strings are stored within single record. No joins.*/
SELECT * FROM employees WHERE id = 1;