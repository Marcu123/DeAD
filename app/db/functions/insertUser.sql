--inserts user into database in a safe way checking if username or email already exists in our database
CREATE OR REPLACE FUNCTION insertUser(p_username varchar(30), 
									  p_password varchar(30),
									  p_email varchar(30),
									  p_cnp varchar(30),
									  p_phone_number varchar(30),
                                      p_activation_code text
									  )
RETURNS integer AS $code$
DECLARE
	code integer;
	v_count integer;
BEGIN
	code := 0;

	SELECT count(*) INTO v_count FROM users WHERE username = p_username;
	if v_count != 0 THEN
		code := 1;
	END IF;
	
	SELECT count(*) INTO v_count FROM users WHERE email = p_email;
	IF v_count != 0 THEN
		code := 2;
	END IF;

	SELECT count(*) INTO v_count FROM users WHERE cnp = p_cnp;
	IF v_count != 0 THEN
		code := 3;
	END IF;
	
	IF code = 0 THEN
		INSERT INTO users(username, password, email, cnp, phone_number, account_created, enabled, activation_code)
		VALUES (p_username, p_password, p_email, p_cnp, p_phone_number, now(), false, p_activation_code);
	END IF;
	
	RETURN code;
END;
$code$ LANGUAGE plpgsql;