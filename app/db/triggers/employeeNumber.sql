CREATE OR REPLACE FUNCTION incEmployeeNumber()
RETURNS TRIGGER AS
$$
BEGIN
UPDATE prison set employee_number = employee_number + 1 where id = NEW.id_prison;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER increment_employee_number
AFTER INSERT ON employee
FOR EACH ROW
EXECUTE FUNCTION incEmployeeNumber();
