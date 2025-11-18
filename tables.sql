-- use vdms database
-- create tables

-- users (auth)
CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'admin',
  created TIMESTAMP WITH TIME ZONE DEFAULT now(),
  modified TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- vehicles
CREATE TABLE vehicles (
  id SERIAL PRIMARY KEY,
  vehicle_code VARCHAR(50) NOT NULL UNIQUE,
  registration_no VARCHAR(100) NOT NULL,
  registration_from DATE,
  registration_to DATE,
  make_model VARCHAR(255),
  vehicle_type VARCHAR(50),
  fuel_type VARCHAR(50),
  engine_no VARCHAR(150),
  chassis_no VARCHAR(150),
  seating_capacity INTEGER,
  fitness_from DATE,
  fitness_to DATE,
  assigned_department VARCHAR(255),
  status VARCHAR(50) DEFAULT 'Active',
  purchase_date DATE,
  purchase_value NUMERIC(14,2),
  vendor VARCHAR(255),
  warranty_period VARCHAR(100),
  puc_from DATE,
  puc_to DATE,
  registration_doc VARCHAR(255),
  bill_doc VARCHAR(255),
  photo_front VARCHAR(255),
  photo_back VARCHAR(255),
  created TIMESTAMP WITH TIME ZONE DEFAULT now(),
  modified TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- drivers
CREATE TABLE drivers (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  father_name VARCHAR(255),
  address TEXT,
  contact_no VARCHAR(50),
  license_no VARCHAR(150) UNIQUE,
  license_validity DATE,
  joining_date DATE,
  status VARCHAR(50) DEFAULT 'Active',
  photo VARCHAR(255),
  created TIMESTAMP WITH TIME ZONE DEFAULT now(),
  modified TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- driver_assignments
CREATE TABLE driver_assignments (
  id SERIAL PRIMARY KEY,
  vehicle_id INTEGER REFERENCES vehicles(id) ON DELETE SET NULL,
  driver_id INTEGER REFERENCES drivers(id) ON DELETE SET NULL,
  start_date DATE,
  end_date DATE
);

-- insurance
CREATE TABLE insurance (
  id SERIAL PRIMARY KEY,
  vehicle_id INTEGER REFERENCES vehicles(id) ON DELETE CASCADE,
  policy_no VARCHAR(255),
  provider VARCHAR(255),
  start_date DATE,
  expiry_date DATE,
  premium NUMERIC(14,2),
  status VARCHAR(50),
  created TIMESTAMP WITH TIME ZONE DEFAULT now(),
  modified TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- maintenance
CREATE TABLE maintenance (
  id SERIAL PRIMARY KEY,
  vehicle_id INTEGER REFERENCES vehicles(id) ON DELETE CASCADE,
  service_date DATE,
  service_type VARCHAR(50),
  service_details TEXT,
  vendor VARCHAR(255),
  parts_replaced TEXT,
  cost NUMERIC(14,2),
  work_order_no VARCHAR(255),
  bill_no VARCHAR(255),
  bill_date DATE,
  next_service_due DATE,
  amc_warranty BOOLEAN DEFAULT false
);

-- fuel_logs
CREATE TABLE fuel_logs (
  id SERIAL PRIMARY KEY,
  vehicle_id INTEGER REFERENCES vehicles(id) ON DELETE CASCADE,
  driver_id INTEGER REFERENCES drivers(id) ON DELETE SET NULL,
  date DATE,
  fuel_qty NUMERIC(10,2),
  fuel_cost NUMERIC(14,2),
  odometer INTEGER,
  mileage NUMERIC(8,2)
);

-- alerts
CREATE TABLE alerts (
  id SERIAL PRIMARY KEY,
  alert_type VARCHAR(50),
  vehicle_id INTEGER REFERENCES vehicles(id) ON DELETE SET NULL,
  driver_id INTEGER REFERENCES drivers(id) ON DELETE SET NULL,
  due_date DATE,
  status VARCHAR(50) DEFAULT 'Pending',
  message TEXT,
  created TIMESTAMP WITH TIME ZONE DEFAULT now()
);
