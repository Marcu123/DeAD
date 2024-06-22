CREATE OR REPLACE FUNCTION bindWitness(p_visit_id INTEGER, p_witness_cnp VARCHAR)
    RETURNS BOOLEAN AS $$
DECLARE
    v_ok BOOLEAN;
    v_id INTEGER;
BEGIN
    IF EXISTS(SELECT * FROM visitor WHERE cnp = p_witness_cnp) THEN
        v_ok := true;
        SELECT id INTO v_id FROM visitor WHERE cnp = p_witness_cnp;
        INSERT INTO witnesses(id_visit, id_visitor) values(p_visit_id, v_id);
    ELSIF EXISTS(SELECT * FROM employee WHERE cnp = p_witness_cnp) THEN
        v_ok :=  true;
        SELECT id INTO v_id FROM employee WHERE cnp = p_witness_cnp;
        INSERT INTO witnesses(id_visit, id_employee) values(p_visit_id, v_id);
    END IF;

    RETURN v_ok;
END;
$$  LANGUAGE plpgsql