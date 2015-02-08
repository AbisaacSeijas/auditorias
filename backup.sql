--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.5
-- Dumped by pg_dump version 9.3.5
-- Started on 2015-02-08 19:03:38

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 13 (class 2615 OID 35847)
-- Name: audit; Type: SCHEMA; Schema: -; Owner: audit
--

CREATE SCHEMA audit;


ALTER SCHEMA audit OWNER TO audit;

SET search_path = audit, pg_catalog;

--
-- TOC entry 1159 (class 1255 OID 52349)
-- Name: generate_order_number(); Type: FUNCTION; Schema: audit; Owner: postgres
--

CREATE FUNCTION generate_order_number() RETURNS trigger
    LANGUAGE plpgsql
    AS $$

DECLARE

-- VARIABLES LOCALES

 _NAME_SEQUENCE text;

BEGIN

 _NAME_SEQUENCE = 'ORD_' || SUBSTRING(EXTRACT('YEAR' FROM NEW.assingment_date)::text, 3);

 BEGIN

  EXECUTE 'CREATE SEQUENCE audit.' || LOWER(_NAME_SEQUENCE) || '
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1';
  
 EXCEPTION WHEN OTHERS THEN END;

 NEW.order_number =  CONCAT_WS('-', 'ORD', LPAD(NEXTVAL(('audit.' || LOWER(_NAME_SEQUENCE))::regclass)::character varying, 6, '0'), EXTRACT('YEAR' FROM NEW.assingment_date));

 RETURN NEW;

    END;
$$;


ALTER FUNCTION audit.generate_order_number() OWNER TO postgres;

--
-- TOC entry 1158 (class 1255 OID 52348)
-- Name: get_order_number(integer); Type: FUNCTION; Schema: audit; Owner: postgres
--

CREATE FUNCTION get_order_number(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE

-- PARAMETROS
	_FISCAL_YEAR ALIAS FOR $1;

-- VARIABLES LOCALES

	_ORDER_NUMBER character varying (12);
	_NAME_SEQUENCE character varying (5);
	_START bigint;

BEGIN

	_NAME_SEQUENCE = 'ORD' || SUBSTRING(_FISCAL_YEAR::text, 3);

	IF NOT EXISTS (SELECT * FROM pg_class WHERE relkind = 'S' AND oid::regclass::text = 'audit.' || quote_ident(LOWER(_NAME_SEQUENCE))) THEN

		SELECT INTO _START t.start FROM (
			SELECT LOWER(substring(form_number,1,3)) AS prefix, MAX(substring(form_number,6)::bigint) + 1 AS start
			FROM audits WHERE order_number LIKE '___-1%' AND id_user = 198
			GROUP BY LOWER(substring(form_number,1,3))
		) AS t
		WHERE t.prefix = quote_ident(LOWER(_NAME_SEQUENCE));

		IF (NOT FOUND) THEN _START = 1; END IF;
		
		EXECUTE 'CREATE SEQUENCE audit.' || LOWER(_NAME_SEQUENCE) || '
		INCREMENT 1
		MINVALUE 1
		MAXVALUE 9223372036854775807
		START ' || _START || '
		CACHE 1';
	END IF;

	SELECT INTO _ORDER_NUMBER _NAME_SEQUENCE || '-1' || LPAD(NEXTVAL(('audit.' || LOWER(_NAME_SEQUENCE))::regclass)::character varying,7,'0'); 

	RETURN _ORDER_NUMBER;
END$_$;


ALTER FUNCTION audit.get_order_number(integer) OWNER TO postgres;

--
-- TOC entry 969 (class 1259 OID 44141)
-- Name: audit_status_id_seq; Type: SEQUENCE; Schema: audit; Owner: postgres
--

CREATE SEQUENCE audit_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE audit.audit_status_id_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 967 (class 1259 OID 35895)
-- Name: audit_status; Type: TABLE; Schema: audit; Owner: audit; Tablespace: 
--

CREATE TABLE audit_status (
    id integer DEFAULT nextval('audit_status_id_seq'::regclass) NOT NULL,
    id_status integer,
    id_audit integer,
    id_user integer,
    observation text,
    date date,
    created_at date,
    deleted_at date,
    updated_at date
);


ALTER TABLE audit.audit_status OWNER TO audit;

--
-- TOC entry 968 (class 1259 OID 35917)
-- Name: audits_id_seq; Type: SEQUENCE; Schema: audit; Owner: postgres
--

CREATE SEQUENCE audits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE audit.audits_id_seq OWNER TO postgres;

--
-- TOC entry 963 (class 1259 OID 35848)
-- Name: audits; Type: TABLE; Schema: audit; Owner: postgres; Tablespace: 
--

CREATE TABLE audits (
    id integer DEFAULT nextval('audits_id_seq'::regclass) NOT NULL,
    id_tax integer,
    id_requirement integer,
    id_reception integer,
    id_result integer,
    id_status integer,
    id_identification_repair integer,
    created_at date,
    deleted_at date,
    updated_at date,
    fiscal_years integer[],
    reason text,
    observ text,
    assingment_date date,
    id_user integer,
    order_number text,
    id_notification integer,
    id_final_review integer,
    id_result_notification integer,
    id_resolution_notification integer,
    amount double precision,
    fiscal_act_number text,
    result text,
    id_resolution_review integer
);


ALTER TABLE audit.audits OWNER TO postgres;

--
-- TOC entry 972 (class 1259 OID 44147)
-- Name: status_id_seq; Type: SEQUENCE; Schema: audit; Owner: postgres
--

CREATE SEQUENCE status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE audit.status_id_seq OWNER TO postgres;

--
-- TOC entry 966 (class 1259 OID 35887)
-- Name: status; Type: TABLE; Schema: audit; Owner: audit; Tablespace: 
--

CREATE TABLE status (
    id integer DEFAULT nextval('status_id_seq'::regclass) NOT NULL,
    name character varying,
    created_at date,
    updated_at date,
    deleted_at date
);


ALTER TABLE audit.status OWNER TO audit;

--
-- TOC entry 1006 (class 1259 OID 60540)
-- Name: audit_data; Type: VIEW; Schema: audit; Owner: postgres
--

CREATE VIEW audit_data AS
 SELECT audits.id,
    audits.order_number,
    audits.fiscal_act_number,
    audits.result,
    audits.amount,
    notification.id_status AS id_status_notification,
    notification.id_user AS id_user_notification,
    notification.observation AS observation_notification,
    notification.date AS date_notification,
    notification_status.name AS name_notification_status,
    requirement.id_status AS id_status_requirement,
    requirement.id_user AS id_user_requirement,
    requirement.observation AS observation_requirement,
    requirement.date AS date_requirement,
    requirement_status.name AS name_requirement_status,
    reception.id_status AS id_status_reception,
    reception.id_user AS id_user_reception,
    reception.observation AS observation_reception,
    reception.date AS date_reception,
    reception_status.name AS name_reception_status,
    final_review.id_status AS id_status_final_review,
    final_review.id_user AS id_user_final_review,
    final_review.observation AS observation_final_review,
    final_review.date AS date_final_review,
    final_review_status.name AS name_final_review_status,
    result_notification.id_status AS id_status_result_notification,
    result_notification.id_user AS id_user_result_notification,
    result_notification.observation AS observation_result_notification,
    result_notification.date AS date_result_notification,
    result_notification_status.name AS name_result_notification_status,
    resolution_review.id_status AS id_status_resolution_review,
    resolution_review.id_user AS id_user_resolution_review,
    resolution_review.observation AS observation_resolution_review,
    resolution_review.date AS date_resolution_review,
    resolution_review_status.name AS name_resolution_review_status,
    resolution_notification.id_status AS id_status_resolution_notification,
    resolution_notification.id_user AS id_user_resolution_notification,
    resolution_notification.observation AS observation_resolution_notification,
    resolution_notification.date AS date_resolution_notification,
    resolution_notification_status.name AS name_resolution_notification_status,
    NULL::date AS created_at,
    NULL::date AS deleted_at,
    NULL::date AS updated_at
   FROM ((((((((((((((audits
     LEFT JOIN audit_status notification ON ((audits.id_notification = notification.id)))
     LEFT JOIN status notification_status ON ((notification.id_status = notification_status.id)))
     LEFT JOIN audit_status requirement ON ((audits.id_requirement = requirement.id)))
     LEFT JOIN status requirement_status ON ((requirement.id_status = requirement_status.id)))
     LEFT JOIN audit_status reception ON ((audits.id_reception = reception.id)))
     LEFT JOIN status reception_status ON ((reception.id_status = reception_status.id)))
     LEFT JOIN audit_status final_review ON ((audits.id_final_review = final_review.id)))
     LEFT JOIN status final_review_status ON ((final_review.id_status = final_review_status.id)))
     LEFT JOIN audit_status result_notification ON ((audits.id_result_notification = result_notification.id)))
     LEFT JOIN status result_notification_status ON ((result_notification.id_status = result_notification_status.id)))
     LEFT JOIN audit_status resolution_review ON ((audits.id_resolution_review = resolution_review.id)))
     LEFT JOIN status resolution_review_status ON ((resolution_review.id_status = resolution_review_status.id)))
     LEFT JOIN audit_status resolution_notification ON ((audits.id_resolution_notification = resolution_notification.id)))
     LEFT JOIN status resolution_notification_status ON ((resolution_notification.id_status = resolution_notification_status.id)));


ALTER TABLE audit.audit_data OWNER TO postgres;

--
-- TOC entry 973 (class 1259 OID 52351)
-- Name: ord_15; Type: SEQUENCE; Schema: audit; Owner: postgres
--

CREATE SEQUENCE ord_15
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE audit.ord_15 OWNER TO postgres;

--
-- TOC entry 974 (class 1259 OID 52353)
-- Name: ord_16; Type: SEQUENCE; Schema: audit; Owner: postgres
--

CREATE SEQUENCE ord_16
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE audit.ord_16 OWNER TO postgres;

--
-- TOC entry 970 (class 1259 OID 44143)
-- Name: repair_details_id_seq; Type: SEQUENCE; Schema: audit; Owner: postgres
--

CREATE SEQUENCE repair_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE audit.repair_details_id_seq OWNER TO postgres;

--
-- TOC entry 965 (class 1259 OID 35866)
-- Name: repair_details; Type: TABLE; Schema: audit; Owner: audit; Tablespace: 
--

CREATE TABLE repair_details (
    id integer DEFAULT nextval('repair_details_id_seq'::regclass) NOT NULL,
    id_repair integer,
    id_tax_class integer,
    old_amount double precision,
    amount double precision,
    new_activity boolean,
    permissed boolean,
    created_at date,
    deleted_at date,
    updated_at date
);


ALTER TABLE audit.repair_details OWNER TO audit;

--
-- TOC entry 971 (class 1259 OID 44145)
-- Name: repairs_id_seq; Type: SEQUENCE; Schema: audit; Owner: postgres
--

CREATE SEQUENCE repairs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE audit.repairs_id_seq OWNER TO postgres;

--
-- TOC entry 964 (class 1259 OID 35856)
-- Name: repairs; Type: TABLE; Schema: audit; Owner: audit; Tablespace: 
--

CREATE TABLE repairs (
    id integer DEFAULT nextval('repairs_id_seq'::regclass) NOT NULL,
    id_audit integer,
    id_statement integer,
    total double precision,
    percent_fine double precision,
    created_at date,
    deleted_at date,
    updated_at date
);


ALTER TABLE audit.repairs OWNER TO audit;

--
-- TOC entry 4185 (class 0 OID 35895)
-- Dependencies: 967
-- Data for Name: audit_status; Type: TABLE DATA; Schema: audit; Owner: audit
--



--
-- TOC entry 4197 (class 0 OID 0)
-- Dependencies: 969
-- Name: audit_status_id_seq; Type: SEQUENCE SET; Schema: audit; Owner: postgres
--

SELECT pg_catalog.setval('audit_status_id_seq', 1, false);


--
-- TOC entry 4181 (class 0 OID 35848)
-- Dependencies: 963
-- Data for Name: audits; Type: TABLE DATA; Schema: audit; Owner: postgres
--



--
-- TOC entry 4198 (class 0 OID 0)
-- Dependencies: 968
-- Name: audits_id_seq; Type: SEQUENCE SET; Schema: audit; Owner: postgres
--

SELECT pg_catalog.setval('audits_id_seq', 9, true);


--
-- TOC entry 4199 (class 0 OID 0)
-- Dependencies: 973
-- Name: ord_15; Type: SEQUENCE SET; Schema: audit; Owner: postgres
--

SELECT pg_catalog.setval('ord_15', 2, true);


--
-- TOC entry 4200 (class 0 OID 0)
-- Dependencies: 974
-- Name: ord_16; Type: SEQUENCE SET; Schema: audit; Owner: postgres
--

SELECT pg_catalog.setval('ord_16', 1, true);


--
-- TOC entry 4183 (class 0 OID 35866)
-- Dependencies: 965
-- Data for Name: repair_details; Type: TABLE DATA; Schema: audit; Owner: audit
--



--
-- TOC entry 4201 (class 0 OID 0)
-- Dependencies: 970
-- Name: repair_details_id_seq; Type: SEQUENCE SET; Schema: audit; Owner: postgres
--

SELECT pg_catalog.setval('repair_details_id_seq', 1, false);


--
-- TOC entry 4182 (class 0 OID 35856)
-- Dependencies: 964
-- Data for Name: repairs; Type: TABLE DATA; Schema: audit; Owner: audit
--



--
-- TOC entry 4202 (class 0 OID 0)
-- Dependencies: 971
-- Name: repairs_id_seq; Type: SEQUENCE SET; Schema: audit; Owner: postgres
--

SELECT pg_catalog.setval('repairs_id_seq', 1, false);


--
-- TOC entry 4184 (class 0 OID 35887)
-- Dependencies: 966
-- Data for Name: status; Type: TABLE DATA; Schema: audit; Owner: audit
--



--
-- TOC entry 4203 (class 0 OID 0)
-- Dependencies: 972
-- Name: status_id_seq; Type: SEQUENCE SET; Schema: audit; Owner: postgres
--

SELECT pg_catalog.setval('status_id_seq', 1, false);


--
-- TOC entry 4044 (class 2606 OID 35852)
-- Name: auditorias_pkey; Type: CONSTRAINT; Schema: audit; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY audits
    ADD CONSTRAINT auditorias_pkey PRIMARY KEY (id);


--
-- TOC entry 4046 (class 2606 OID 35860)
-- Name: repair; Type: CONSTRAINT; Schema: audit; Owner: audit; Tablespace: 
--

ALTER TABLE ONLY repairs
    ADD CONSTRAINT repair PRIMARY KEY (id);


--
-- TOC entry 4048 (class 2606 OID 35870)
-- Name: repair_det; Type: CONSTRAINT; Schema: audit; Owner: audit; Tablespace: 
--

ALTER TABLE ONLY repair_details
    ADD CONSTRAINT repair_det PRIMARY KEY (id);


--
-- TOC entry 4050 (class 2606 OID 35894)
-- Name: stat; Type: CONSTRAINT; Schema: audit; Owner: audit; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT stat PRIMARY KEY (id);


--
-- TOC entry 4052 (class 2606 OID 35902)
-- Name: stats_audits; Type: CONSTRAINT; Schema: audit; Owner: audit; Tablespace: 
--

ALTER TABLE ONLY audit_status
    ADD CONSTRAINT stats_audits PRIMARY KEY (id);


--
-- TOC entry 4058 (class 2620 OID 52350)
-- Name: generate_order_number; Type: TRIGGER; Schema: audit; Owner: postgres
--

CREATE TRIGGER generate_order_number BEFORE INSERT ON audits FOR EACH ROW EXECUTE PROCEDURE generate_order_number();


--
-- TOC entry 4054 (class 2606 OID 35861)
-- Name: audit_repair; Type: FK CONSTRAINT; Schema: audit; Owner: audit
--

ALTER TABLE ONLY repairs
    ADD CONSTRAINT audit_repair FOREIGN KEY (id_audit) REFERENCES audits(id);


--
-- TOC entry 4057 (class 2606 OID 35903)
-- Name: audits_stat_audits; Type: FK CONSTRAINT; Schema: audit; Owner: audit
--

ALTER TABLE ONLY audit_status
    ADD CONSTRAINT audits_stat_audits FOREIGN KEY (id_audit) REFERENCES audits(id);


--
-- TOC entry 4055 (class 2606 OID 35871)
-- Name: repair_repair_det; Type: FK CONSTRAINT; Schema: audit; Owner: audit
--

ALTER TABLE ONLY repair_details
    ADD CONSTRAINT repair_repair_det FOREIGN KEY (id_repair) REFERENCES repairs(id);


--
-- TOC entry 4053 (class 2606 OID 35876)
-- Name: repair_statement; Type: FK CONSTRAINT; Schema: audit; Owner: audit
--

ALTER TABLE ONLY repairs
    ADD CONSTRAINT repair_statement FOREIGN KEY (id_statement) REFERENCES public.statement(id);


--
-- TOC entry 4056 (class 2606 OID 35908)
-- Name: stat_audits_stat; Type: FK CONSTRAINT; Schema: audit; Owner: audit
--

ALTER TABLE ONLY audit_status
    ADD CONSTRAINT stat_audits_stat FOREIGN KEY (id_status) REFERENCES status(id);


-- Completed on 2015-02-08 19:03:39

--
-- PostgreSQL database dump complete
--

