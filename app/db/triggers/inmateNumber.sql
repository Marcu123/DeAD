CREATE OR REPLACE FUNCTION incInmateNumber()
    RETURNS TRIGGER AS
$$
BEGIN
    UPDATE prison set inmate_number = inmate_number + 1 where id = NEW.id_prison;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER increment_inmate_number
    AFTER INSERT ON inmate
    FOR EACH ROW
EXECUTE FUNCTION incInmateNumber();