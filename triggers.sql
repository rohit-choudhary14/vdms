CREATE OR REPLACE FUNCTION table_specific_audit()
RETURNS TRIGGER AS $$
DECLARE
    v_ip TEXT;
BEGIN
    -- Get IP passed from application layer
    SELECT current_setting('application_name') INTO v_ip;

    IF (TG_OP = 'INSERT') THEN
        EXECUTE format(
            'INSERT INTO %I_log(operation, new_data, performed_by, user_ip)
             VALUES (%L, row_to_json($1), %L, %L)',
             TG_TABLE_NAME, TG_OP, session_user, v_ip
        ) USING NEW;
        RETURN NEW;

    ELSIF (TG_OP = 'UPDATE') THEN
        EXECUTE format(
            'INSERT INTO %I_log(operation, old_data, new_data, performed_by, user_ip)
             VALUES (%L, row_to_json($1), row_to_json($2), %L, %L)',
             TG_TABLE_NAME, TG_OP, session_user, v_ip
        ) USING OLD, NEW;
        RETURN NEW;

    ELSIF (TG_OP = 'DELETE') THEN
        EXECUTE format(
            'INSERT INTO %I_log(operation, old_data, performed_by, user_ip)
             VALUES (%L, row_to_json($1), %L, %L)',
             TG_TABLE_NAME, TG_OP, session_user, v_ip
        ) USING OLD;
        RETURN OLD;

    END IF;
END;
$$ LANGUAGE plpgsql;