--
-- PostgreSQL database dump
--

-- Dumped from database version 13.21
-- Dumped by pg_dump version 13.21

-- Started on 2025-10-02 20:35:07

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 670 (class 1247 OID 17180)
-- Name: insurance_nature; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.insurance_nature AS ENUM (
    'Comprehensive',
    'Third Party'
);


ALTER TYPE public.insurance_nature OWNER TO postgres;

--
-- TOC entry 667 (class 1247 OID 17151)
-- Name: insurance_status; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.insurance_status AS ENUM (
    'Active',
    'Expired',
    'Renewed'
);


ALTER TYPE public.insurance_status OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 17307)
-- Name: accidents; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.accidents (
    accident_id integer NOT NULL,
    vehicle_code character varying(50) NOT NULL,
    driver_code character varying(50) NOT NULL,
    date_time timestamp without time zone NOT NULL,
    location character varying(255) NOT NULL,
    nature_of_accident character varying(50),
    fir_no character varying(100),
    court_case_details text,
    repair_cost numeric(12,2),
    insurance_claim_status character varying(20),
    CONSTRAINT accidents_insurance_claim_status_check CHECK (((insurance_claim_status)::text = ANY ((ARRAY['Pending'::character varying, 'Approved'::character varying, 'Rejected'::character varying])::text[]))),
    CONSTRAINT accidents_nature_of_accident_check CHECK (((nature_of_accident)::text = ANY ((ARRAY['Minor'::character varying, 'Major'::character varying, 'Damage'::character varying])::text[])))
);


ALTER TABLE public.accidents OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 17305)
-- Name: accidents_accident_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.accidents_accident_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.accidents_accident_id_seq OWNER TO postgres;

--
-- TOC entry 3124 (class 0 OID 0)
-- Dependencies: 216
-- Name: accidents_accident_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.accidents_accident_id_seq OWNED BY public.accidents.accident_id;


--
-- TOC entry 211 (class 1259 OID 16928)
-- Name: alerts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.alerts (
    id integer NOT NULL,
    alert_type character varying(50),
    vehicle_id integer,
    driver_id integer,
    due_date date,
    status character varying(50) DEFAULT 'Pending'::character varying,
    message text,
    created timestamp with time zone DEFAULT now()
);


ALTER TABLE public.alerts OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16926)
-- Name: alerts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.alerts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.alerts_id_seq OWNER TO postgres;

--
-- TOC entry 3125 (class 0 OID 0)
-- Dependencies: 210
-- Name: alerts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.alerts_id_seq OWNED BY public.alerts.id;


--
-- TOC entry 207 (class 1259 OID 16857)
-- Name: driver_assignments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.driver_assignments (
    id integer NOT NULL,
    start_date date,
    end_date date,
    driver_code character varying(50),
    vehicle_code character varying(50)
);


ALTER TABLE public.driver_assignments OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 16855)
-- Name: driver_assignments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.driver_assignments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.driver_assignments_id_seq OWNER TO postgres;

--
-- TOC entry 3126 (class 0 OID 0)
-- Dependencies: 206
-- Name: driver_assignments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.driver_assignments_id_seq OWNED BY public.driver_assignments.id;


--
-- TOC entry 205 (class 1259 OID 16841)
-- Name: drivers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.drivers (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    father_name character varying(255),
    address text,
    contact_no character varying(50),
    license_no character varying(150),
    license_validity date,
    joining_date date,
    status character varying(50) DEFAULT 'Active'::character varying,
    photo character varying(255),
    created timestamp with time zone DEFAULT now(),
    modified timestamp with time zone DEFAULT now(),
    driver_code character varying(50) NOT NULL,
    driver_photo character varying(50),
    license_doc character varying(50)
);


ALTER TABLE public.drivers OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 16839)
-- Name: drivers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.drivers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.drivers_id_seq OWNER TO postgres;

--
-- TOC entry 3127 (class 0 OID 0)
-- Dependencies: 204
-- Name: drivers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.drivers_id_seq OWNED BY public.drivers.id;


--
-- TOC entry 215 (class 1259 OID 17208)
-- Name: fuel; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fuel (
    fuel_id integer NOT NULL,
    refuel_date date NOT NULL,
    fuel_quantity numeric(10,2) NOT NULL,
    fuel_cost numeric(10,2) NOT NULL,
    odometer_reading integer NOT NULL,
    mileage numeric(10,2),
    created timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    modified timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    vehicle_code character varying(50),
    driver_code character varying(50)
);


ALTER TABLE public.fuel OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 17206)
-- Name: fuel_logs_fuel_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fuel_logs_fuel_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.fuel_logs_fuel_id_seq OWNER TO postgres;

--
-- TOC entry 3128 (class 0 OID 0)
-- Dependencies: 214
-- Name: fuel_logs_fuel_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fuel_logs_fuel_id_seq OWNED BY public.fuel.fuel_id;


--
-- TOC entry 213 (class 1259 OID 17187)
-- Name: insurance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.insurance (
    insurance_id integer NOT NULL,
    vehicle_code character varying(50) NOT NULL,
    policy_no character varying(100) NOT NULL,
    nature public.insurance_nature DEFAULT 'Comprehensive'::public.insurance_nature,
    insurer_name character varying(150) NOT NULL,
    insurer_contact character varying(100),
    insurer_address text,
    start_date date NOT NULL,
    expiry_date date NOT NULL,
    premium_amount numeric(10,2) NOT NULL,
    addons text,
    next_due date NOT NULL,
    document character varying(255),
    renewal_alert boolean DEFAULT false,
    status public.insurance_status DEFAULT 'Active'::public.insurance_status,
    created timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    modified timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.insurance OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 17185)
-- Name: insurance_insurance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.insurance_insurance_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.insurance_insurance_id_seq OWNER TO postgres;

--
-- TOC entry 3129 (class 0 OID 0)
-- Dependencies: 212
-- Name: insurance_insurance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.insurance_insurance_id_seq OWNED BY public.insurance.insurance_id;


--
-- TOC entry 209 (class 1259 OID 16893)
-- Name: maintenance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.maintenance (
    id integer NOT NULL,
    vehicle_code character varying(50),
    service_date date,
    service_type character varying(50),
    service_details text,
    vendor character varying(255),
    parts_replaced text,
    cost numeric(14,2),
    work_order_no character varying(255),
    bill_no character varying(255),
    bill_date date,
    next_service_due date,
    amc_warranty boolean DEFAULT false,
    bill_document character varying(50)
);


ALTER TABLE public.maintenance OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 16891)
-- Name: maintenance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.maintenance_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.maintenance_id_seq OWNER TO postgres;

--
-- TOC entry 3130 (class 0 OID 0)
-- Dependencies: 208
-- Name: maintenance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.maintenance_id_seq OWNED BY public.maintenance.id;


--
-- TOC entry 201 (class 1259 OID 16812)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying(100) NOT NULL,
    password character varying(255) NOT NULL,
    role character varying(50) DEFAULT 'admin'::character varying,
    created timestamp with time zone DEFAULT now(),
    modified timestamp with time zone DEFAULT now()
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 16810)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 3131 (class 0 OID 0)
-- Dependencies: 200
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 203 (class 1259 OID 16825)
-- Name: vehicles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vehicles (
    id integer NOT NULL,
    vehicle_code character varying(50) NOT NULL,
    registration_no character varying(100) NOT NULL,
    registration_from date,
    registration_to date,
    make_model character varying(255),
    vehicle_type character varying(50),
    fuel_type character varying(50),
    engine_no character varying(150),
    chassis_no character varying(150),
    seating_capacity integer,
    fitness_from date,
    fitness_to date,
    assigned_department character varying(255),
    status character varying(50) DEFAULT 'Active'::character varying,
    purchase_date date,
    purchase_value numeric(14,2),
    vendor character varying(255),
    warranty_period character varying(100),
    puc_from date,
    puc_to date,
    registration_doc character varying(255),
    bill_doc character varying(255),
    photo_front character varying(255),
    photo_back character varying(255),
    created timestamp with time zone DEFAULT now(),
    modified timestamp with time zone DEFAULT now()
);


ALTER TABLE public.vehicles OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 16823)
-- Name: vehicles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vehicles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vehicles_id_seq OWNER TO postgres;

--
-- TOC entry 3132 (class 0 OID 0)
-- Dependencies: 202
-- Name: vehicles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vehicles_id_seq OWNED BY public.vehicles.id;


--
-- TOC entry 2937 (class 2604 OID 17310)
-- Name: accidents accident_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accidents ALTER COLUMN accident_id SET DEFAULT nextval('public.accidents_accident_id_seq'::regclass);


--
-- TOC entry 2925 (class 2604 OID 16931)
-- Name: alerts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alerts ALTER COLUMN id SET DEFAULT nextval('public.alerts_id_seq'::regclass);


--
-- TOC entry 2922 (class 2604 OID 16860)
-- Name: driver_assignments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_assignments ALTER COLUMN id SET DEFAULT nextval('public.driver_assignments_id_seq'::regclass);


--
-- TOC entry 2918 (class 2604 OID 16844)
-- Name: drivers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.drivers ALTER COLUMN id SET DEFAULT nextval('public.drivers_id_seq'::regclass);


--
-- TOC entry 2934 (class 2604 OID 17211)
-- Name: fuel fuel_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fuel ALTER COLUMN fuel_id SET DEFAULT nextval('public.fuel_logs_fuel_id_seq'::regclass);


--
-- TOC entry 2928 (class 2604 OID 17190)
-- Name: insurance insurance_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance ALTER COLUMN insurance_id SET DEFAULT nextval('public.insurance_insurance_id_seq'::regclass);


--
-- TOC entry 2923 (class 2604 OID 16896)
-- Name: maintenance id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.maintenance ALTER COLUMN id SET DEFAULT nextval('public.maintenance_id_seq'::regclass);


--
-- TOC entry 2910 (class 2604 OID 16815)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 2914 (class 2604 OID 16828)
-- Name: vehicles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vehicles ALTER COLUMN id SET DEFAULT nextval('public.vehicles_id_seq'::regclass);


--
-- TOC entry 3118 (class 0 OID 17307)
-- Dependencies: 217
-- Data for Name: accidents; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.accidents (accident_id, vehicle_code, driver_code, date_time, location, nature_of_accident, fir_no, court_case_details, repair_cost, insurance_claim_status) FROM stdin;
\.


--
-- TOC entry 3112 (class 0 OID 16928)
-- Dependencies: 211
-- Data for Name: alerts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.alerts (id, alert_type, vehicle_id, driver_id, due_date, status, message, created) FROM stdin;
\.


--
-- TOC entry 3108 (class 0 OID 16857)
-- Dependencies: 207
-- Data for Name: driver_assignments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.driver_assignments (id, start_date, end_date, driver_code, vehicle_code) FROM stdin;
\.


--
-- TOC entry 3106 (class 0 OID 16841)
-- Dependencies: 205
-- Data for Name: drivers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.drivers (id, name, father_name, address, contact_no, license_no, license_validity, joining_date, status, photo, created, modified, driver_code, driver_photo, license_doc) FROM stdin;
6	Rohit choudhary	xxxxx	Dhar tankarda tech chomu	7976999536	1234XXXXXXAAAA12	2025-10-15	\N	Active	\N	2025-10-02 19:21:29+05:30	2025-10-02 19:21:29+05:30	DRV-8DFB341B-822C-4D47-88BD-20B936AEC40C	uploads/68de836138390_1759413089.jpeg	uploads/68de836138ec6_1759413089.jpeg
\.


--
-- TOC entry 3116 (class 0 OID 17208)
-- Dependencies: 215
-- Data for Name: fuel; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fuel (fuel_id, refuel_date, fuel_quantity, fuel_cost, odometer_reading, mileage, created, modified, vehicle_code, driver_code) FROM stdin;
\.


--
-- TOC entry 3114 (class 0 OID 17187)
-- Dependencies: 213
-- Data for Name: insurance; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.insurance (insurance_id, vehicle_code, policy_no, nature, insurer_name, insurer_contact, insurer_address, start_date, expiry_date, premium_amount, addons, next_due, document, renewal_alert, status, created, modified) FROM stdin;
7	VEH-85756304-71CB-4F5A-9CF4-BCD594520452	12	Comprehensive	sda	qwqwq	dfsff	2025-10-02	2025-10-03	23232323.00		2025-10-10	uploads\\68de923bf2d74_1759416891.doc	f	Active	2025-10-02 14:22:53.589477	2025-10-02 14:22:53.589477
\.


--
-- TOC entry 3110 (class 0 OID 16893)
-- Dependencies: 209
-- Data for Name: maintenance; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.maintenance (id, vehicle_code, service_date, service_type, service_details, vendor, parts_replaced, cost, work_order_no, bill_no, bill_date, next_service_due, amc_warranty, bill_document) FROM stdin;
\.


--
-- TOC entry 3102 (class 0 OID 16812)
-- Dependencies: 201
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, username, password, role, created, modified) FROM stdin;
\.


--
-- TOC entry 3104 (class 0 OID 16825)
-- Dependencies: 203
-- Data for Name: vehicles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vehicles (id, vehicle_code, registration_no, registration_from, registration_to, make_model, vehicle_type, fuel_type, engine_no, chassis_no, seating_capacity, fitness_from, fitness_to, assigned_department, status, purchase_date, purchase_value, vendor, warranty_period, puc_from, puc_to, registration_doc, bill_doc, photo_front, photo_back, created, modified) FROM stdin;
11	VEH-85756304-71CB-4F5A-9CF4-BCD594520452	RJ 14 1234	\N	\N	honda	car	Diesel	\N	\N	3	\N	\N	\N	Active	2025-10-01	1234567.00	jaipur honda city showroom	\N	\N	\N	uploads/68de831232500_1759413010.pdf	uploads/68de83123428f_1759413010.pdf	uploads/68de831236d63_1759413010.jpg	uploads/68de831237632_1759413010.jpg	2025-10-02 19:20:10+05:30	2025-10-02 19:20:10+05:30
\.


--
-- TOC entry 3133 (class 0 OID 0)
-- Dependencies: 216
-- Name: accidents_accident_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.accidents_accident_id_seq', 1, true);


--
-- TOC entry 3134 (class 0 OID 0)
-- Dependencies: 210
-- Name: alerts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.alerts_id_seq', 1, false);


--
-- TOC entry 3135 (class 0 OID 0)
-- Dependencies: 206
-- Name: driver_assignments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.driver_assignments_id_seq', 3, true);


--
-- TOC entry 3136 (class 0 OID 0)
-- Dependencies: 204
-- Name: drivers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.drivers_id_seq', 6, true);


--
-- TOC entry 3137 (class 0 OID 0)
-- Dependencies: 214
-- Name: fuel_logs_fuel_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fuel_logs_fuel_id_seq', 2, true);


--
-- TOC entry 3138 (class 0 OID 0)
-- Dependencies: 212
-- Name: insurance_insurance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.insurance_insurance_id_seq', 7, true);


--
-- TOC entry 3139 (class 0 OID 0)
-- Dependencies: 208
-- Name: maintenance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.maintenance_id_seq', 1, true);


--
-- TOC entry 3140 (class 0 OID 0)
-- Dependencies: 200
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- TOC entry 3141 (class 0 OID 0)
-- Dependencies: 202
-- Name: vehicles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vehicles_id_seq', 11, true);


--
-- TOC entry 2965 (class 2606 OID 17317)
-- Name: accidents accidents_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accidents
    ADD CONSTRAINT accidents_pkey PRIMARY KEY (accident_id);


--
-- TOC entry 2959 (class 2606 OID 16938)
-- Name: alerts alerts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alerts
    ADD CONSTRAINT alerts_pkey PRIMARY KEY (id);


--
-- TOC entry 2955 (class 2606 OID 16862)
-- Name: driver_assignments driver_assignments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_assignments
    ADD CONSTRAINT driver_assignments_pkey PRIMARY KEY (id);


--
-- TOC entry 2949 (class 2606 OID 17229)
-- Name: drivers drivers_driver_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.drivers
    ADD CONSTRAINT drivers_driver_code_key UNIQUE (driver_code);


--
-- TOC entry 2951 (class 2606 OID 16854)
-- Name: drivers drivers_license_no_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.drivers
    ADD CONSTRAINT drivers_license_no_key UNIQUE (license_no);


--
-- TOC entry 2953 (class 2606 OID 16852)
-- Name: drivers drivers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.drivers
    ADD CONSTRAINT drivers_pkey PRIMARY KEY (id);


--
-- TOC entry 2963 (class 2606 OID 17215)
-- Name: fuel fuel_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fuel
    ADD CONSTRAINT fuel_logs_pkey PRIMARY KEY (fuel_id);


--
-- TOC entry 2961 (class 2606 OID 17200)
-- Name: insurance insurance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.insurance
    ADD CONSTRAINT insurance_pkey PRIMARY KEY (insurance_id);


--
-- TOC entry 2957 (class 2606 OID 16902)
-- Name: maintenance maintenance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.maintenance
    ADD CONSTRAINT maintenance_pkey PRIMARY KEY (id);


--
-- TOC entry 2941 (class 2606 OID 16820)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2943 (class 2606 OID 16822)
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- TOC entry 2945 (class 2606 OID 16836)
-- Name: vehicles vehicles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vehicles
    ADD CONSTRAINT vehicles_pkey PRIMARY KEY (id);


--
-- TOC entry 2947 (class 2606 OID 16838)
-- Name: vehicles vehicles_vehicle_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vehicles
    ADD CONSTRAINT vehicles_vehicle_code_key UNIQUE (vehicle_code);


--
-- TOC entry 2970 (class 2606 OID 17323)
-- Name: accidents accidents_driver_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accidents
    ADD CONSTRAINT accidents_driver_id_fkey FOREIGN KEY (driver_code) REFERENCES public.drivers(driver_code) ON DELETE CASCADE;


--
-- TOC entry 2969 (class 2606 OID 17328)
-- Name: accidents accidents_vehicle_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accidents
    ADD CONSTRAINT accidents_vehicle_id_fkey FOREIGN KEY (vehicle_code) REFERENCES public.vehicles(vehicle_code) ON DELETE CASCADE;


--
-- TOC entry 2968 (class 2606 OID 16944)
-- Name: alerts alerts_driver_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alerts
    ADD CONSTRAINT alerts_driver_id_fkey FOREIGN KEY (driver_id) REFERENCES public.drivers(id) ON DELETE SET NULL;


--
-- TOC entry 2967 (class 2606 OID 16939)
-- Name: alerts alerts_vehicle_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alerts
    ADD CONSTRAINT alerts_vehicle_id_fkey FOREIGN KEY (vehicle_id) REFERENCES public.vehicles(id) ON DELETE SET NULL;


--
-- TOC entry 2966 (class 2606 OID 17347)
-- Name: maintenance fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.maintenance
    ADD CONSTRAINT fkey FOREIGN KEY (vehicle_code) REFERENCES public.vehicles(vehicle_code) NOT VALID;


-- Completed on 2025-10-02 20:35:07

--
-- PostgreSQL database dump complete
--

