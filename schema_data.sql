-- Define the USERS table
CREATE TABLE USERS (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL
);

-- Define the CLIENTS table
CREATE TABLE CLIENTS (
    client_id INT PRIMARY KEY AUTO_INCREMENT,
    client_photo_path TEXT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    address VARCHAR(255),
    phone_number VARCHAR(20),
    suburb VARCHAR(50),
    recruited_from_channel VARCHAR(100)
);

-- Define the ORGANISATIONS table
CREATE TABLE ORGANISATIONS (
    org_id INT PRIMARY KEY AUTO_INCREMENT,
    business_name VARCHAR(100) NOT NULL,
    current_website VARCHAR(255),
    business_description TEXT,
    technology_currently_used VARCHAR(255),
    industry_operated_in VARCHAR(100),
    services_offered TEXT,
    field VARCHAR(100)
);

-- Define the PROJECTS table
CREATE TABLE PROJECTS (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    project_name VARCHAR(100) NOT NULL,
    semester_and_year VARCHAR(20),
    project_description TEXT,
    proposal TEXT,
    what_is_working TEXT,
    what_is_not_working TEXT,
    client_id INT,
    FOREIGN KEY (client_id) REFERENCES CLIENTS(client_id)
);

-- Define the CONTACT US table
CREATE TABLE CONTACT_US (
    form_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone_number VARCHAR(20),
    message TEXT,
    replied BOOLEAN DEFAULT FALSE
);

-- Define the relationship between CLIENTS and CONTACT_US
CREATE TABLE CLIENT_CONTACT_US(
    client_id INT,
    form_id INT,
    PRIMARY KEY (client_id, form_id),
    FOREIGN KEY (client_id) REFERENCES CLIENTS(client_id),
    FOREIGN KEY (form_id) REFERENCES CONTACT_US(form_id)
);

-- Define the many-to-many relationship between CLIENTS and ORGANISATIONS
CREATE TABLE CLIENTS_ORGANISATIONS (
    client_id INT,
    org_id INT,
    PRIMARY KEY (client_id, org_id),
    FOREIGN KEY (client_id) REFERENCES CLIENTS(client_id),
    FOREIGN KEY (org_id) REFERENCES ORGANISATIONS(org_id)
);

INSERT INTO USERS (`username`, `fullname`, `email`, `password`)
VALUES
  ('nAltman', 'Nathan Altman', 'nathan.recruiter@monash.com', SHA2('password', 0));


INSERT INTO CLIENTS (client_photo_path, first_name, surname, email, address, phone_number, suburb, recruited_from_channel)
VALUES
('rachel.jpg', 'Rachel', 'Marshall', 'rachel.marshall@example.com', 'Ap #241-4842 Ultrices Av.', '0422070861', 'Carlton', 'Social Media'),
('hall.jpg', 'Hall', 'Mason', 'hall.mason@example.com', 'P.O. Box 452, 5141 Curabitur Street', '0667332373', 'Coburg', 'Business Meeting'),
('michael.jpg', 'Michael', 'Johnson', 'michael.johnson@example.com', '600-6203 Fusce Street', '0434736135', 'East Melbourne', 'Business Event'),
('emily.jpg', 'Emily', 'Williams', 'emily.williams@example.com', '101 Pine St', '0446764708', 'Northcote', 'Business Convention'),
('william.jpg', 'William', 'Brown', 'william.brown@example.com', '246 Cedar St', '0465145214', 'Clayton', 'Recommended by client'),
('olivia.jpg', 'Olivia', 'Jones', 'olivia.jones@example.com', '369 Birch St', '0497452745', 'St Kilda', 'Recruited from busEd program'),
('james.jpg', 'James', 'Davis', 'james.davis@example.com', '482 Redwood St', '0445594378', 'Nt Melbourne', 'Social media'),
('sophia.jpg', 'Sophia', 'Miller', 'sophia.miller@example.com', '555 Maple St', '0424013624', 'South Yarra', 'Business event'),
('benjamin.jpg', 'Benjamin', 'Garcia', 'benjamin.garcia@example.com', '777 Oak St', '0482608918', 'Craigieburn', 'Recruited from BusEd program'),
('ava.jpg', 'Ava', 'Martinez', 'ava.martinez@example.com', '888 Pine St', '0404473450', 'Epping', 'Social media'),
('liam.jpg', 'Liam', 'Rodriguez', 'liam.rodriguez@example.com', '999 Cedar St', '0468439123', 'Tamarara', 'Social media'),
('mia.jpg', 'Mia', 'Lopez', 'mia.lopez@example.com', '111 Birch St', '0407838837', 'Brighton', 'Business convention'),
('ethan.jpg', 'Ethan', 'Hernandez', 'ethan.hernandez@example.com', '222 Redwood St', '0454369636', 'Kensington', 'Business meeting'),
('isabella.jpg', 'Isabella', 'Smith', 'isabella.smith@example.com', '333 Maple St', '0458252255', 'Surrey Hills', 'Social media'),
('noah.jpg', 'Noah', 'Davis', 'noah.davis@example.com', '444 Oak St', '0416885786', 'Clayton', 'Business event');

INSERT INTO ORGANISATIONS (`business_name`, `current_website`, `business_description`, `technology_currently_used`, `industry_operated_in`, `services_offered`, `field`)
VALUES
  ('Terry and King', 'www.majorChemicalsTK.gov', 'A leading manufacturer of specialty chemicals', 'Chemical Process Control Systems', 'Major Chemicals', 'Chemical Product Development and Distribution', 'Chemical Engineering'),
  ('Ortiz LLC', 'www.nlarretOrtiz.it', 'Innovative technology solutions provider', 'AI and Data Analytics', 'Information technology services', 'Data Analysis and Consulting', 'Information technology'),
  ('Rodriguez, Kautzer and Gleason', 'www.marineRKG.com', 'Marine transport professionals', 'None', 'Marine Transportation', 'Transport marine life to required locations', 'Marine Transport'),
  ('Buckridge-Bailey', 'www.theglobeandmail.com', 'Committed to providing up-to-date and relevant news and current events', 'Renewable energy technology', 'Television Services', 'News and Current events providers', 'Television and Entertainment'),
  ('Kovacek LLC', 'www.kovacek.com', 'Committed to producing effective and aesthetic web designs', 'Wireless technology', 'Business Development', 'Provider of web designs', 'Business and Marketing'),
  ('ABC Corporation', 'www.abccorp.com', 'A leading technology company', 'Cloud computing', 'Information Technology', 'IT Consulting', 'Tech Services'),
  ('XYZ Enterprises', 'www.xyzenterprises.com', 'Provider of innovative solutions', 'Cloud computing', 'Software Development', 'Software as a Service', 'Tech Services'),
  ('Smith & Johnson Ltd', 'www.smithjohnsonltd.com', 'A trusted consulting firm', 'Fintech Solutions', 'Management Consulting', 'Strategic Planning', 'Consulting'),
  ('Sunrise Industries', 'www.sunriseindustries.com', 'Manufacturing excellence', 'Blockchain', 'Manufacturing', 'Product Manufacturing', 'Manufacturing'),
  ('Global Logistics', 'www.globallogistics.com', 'Efficient transportation solutions', 'Wireless technology', 'Logistics and Transportation', 'Freight Forwarding', 'Transportation'),
  ('FoodTech Innovators', 'www.foodtechinnovators.com', 'Revolutionizing the food industry', 'Wireless technology', 'Food and Beverage', 'Food Delivery', 'Food Technology'),
  ('Green Energy Solutions', 'www.greenenergysolutions.com', 'Sustainable energy solutions', 'Renewable Energy technologies', 'Renewable Energy', 'Solar Installation', 'Energy'),
  ('Healthcare Partners', 'www.healthcarepartners.com', 'Improving patient care', 'Healthcare Information Systems', 'Healthcare', 'Medical Services', 'Healthcare'),
  ('Education Experts', 'www.educationexperts.com', 'Empowering learners', 'Cloud Computing', 'Education', 'Online Tutoring', 'Education'),
  ('Artistic Creations', 'www.artisticcreations.com', 'Bringing creativity to life', 'Cloud Computing', 'Arts and Crafts', 'Artistic Services', 'Creative Arts');

  INSERT INTO PROJECTS (`project_name`, `semester_and_year`, `project_description`, `proposal`, `what_is_working`, `what_is_not_working`, `client_id`)
VALUES
  ('Project Redesign', 'Semester 1 2023', 'Redesigning the company website for improved user experience.', 'Proposal for Project Redesign', 'New design is well-received by test users.', 'Some challenges with integrating certain features.', 1),
  ('E-commerce Platform Upgrade', 'Semester 2 2022', 'Enhancing the e-commerce platform to handle increased traffic and transactions.', 'Proposal for E-commerce Platform Upgrade', 'Successfully implemented payment gateway integration.', 'Backend server scalability needs improvement.', 2),
  ('Mobile App Development', 'Semester 2 2022', 'Creating a mobile app to extend services to the mobile platform.', 'Proposal for Mobile App Development', 'Smooth performance across various devices.', 'Minor bugs in user authentication.', 3),
  ('Inventory Management System', 'Semester 1 2022', 'Developing a system to manage inventory and streamline supply chain operations.', 'Proposal for Inventory Management System', 'Efficiently tracks stock levels and alerts for low inventory.', 'Data synchronization issues with multiple warehouses.', 4),
  ('AI-Powered Customer Support', 'Semester 2 2021', 'Integrating AI for handling customer support queries and providing automated responses.', 'Proposal for AI-Powered Customer Support', 'AI model accurately handles a significant number of customer queries.', 'Some customers find it challenging to interact with AI.', 5),
  ('IoT Home Automation', 'Semester 2 2021', 'Building an IoT-based home automation system for improved energy efficiency and security.', 'Proposal for IoT Home Automation', 'Successfully integrated smart devices for centralized control.', 'Occasional connectivity issues with certain devices.', 6),
  ('Health and Fitness App', 'Semester 1 2021', 'Developing an app to track fitness routines, nutrition, and provide health tips.', 'Proposal for Health and Fitness App', 'Users find the app intuitive and helpful for their fitness goals.', 'Calorie tracking feature needs refinement.', 7),
  ('E-learning Platform', 'Semester 2 2020', 'Creating an online platform for educational courses and interactive learning materials.', 'Proposal for E-learning Platform', 'Positive feedback from early testers regarding course content and user interface.', 'Loading time for videos needs optimization.', 8),
  ('Community Engagement Portal', 'Semester 1 2020', 'Designing a portal for community members to collaborate, share ideas, and engage in discussions.', 'Proposal for Community Engagement Portal', 'Active participation and engagement of community members.', 'Notification system needs improvement.', 9),
  ('Sustainable Energy App', 'Semester 2 2019', 'Developing an app to promote sustainable energy practices and provide tips for energy conservation.', 'Proposal for Sustainable Energy App', 'Users appreciate the energy-saving tips and eco-friendly recommendations.', 'Compatibility issues with older smartphone models.', 10),
  ('Virtual Reality Experience', 'Semester 2 2019', 'Creating a virtual reality experience for showcasing products and services.', 'Proposal for Virtual Reality Experience', 'Users are impressed with the immersive VR experience.', 'Hardware requirements for VR may limit accessibility.', 11),
  ('Social Media Analytics Tool', 'Semester 1 2019', 'Building a tool to analyze social media data and provide insights for marketing strategies.', 'Proposal for Social Media Analytics Tool', 'Provides valuable insights for optimizing social media campaigns.', 'Data processing time could be reduced.', 12),
  ('Smart Agriculture Solution', 'Semester 2 2018', 'Developing a technology-driven solution for precision agriculture and efficient farm management.', 'Proposal for Smart Agriculture Solution', 'Farmers experience improved yield and cost savings using the solution.', 'Integration with existing farm equipment needs enhancement.', 13),
  ('Tourism Experience App', 'Semester 2 2018', 'Creating an app that enhances the tourism experience by providing information and personalized recommendations.', 'Proposal for Tourism Experience App', 'Tourists find the app informative and helpful for their travels.', 'Navigation feature needs improvement.', 14),
  ('Environmental Monitoring System', 'Semester 2 2018', 'Designing a system to monitor and report environmental parameters for conservation efforts.', 'Proposal for Environmental Monitoring System', 'Accurate data collection and reporting on environmental conditions.', 'Battery life of monitoring devices needs optimization.', 15),
  ('AI-Enhanced Financial Analytics', 'Semester 1 2019', 'Developing AI-driven tools for financial analysis and investment strategies.', 'Proposal for AI-Enhanced Financial Analytics', 'Accurate predictions for stock market trends.', 'Fine-tuning needed for handling extreme market volatility.', 2),
  ('E-commerce Mobile App', 'Semester 2 2018', 'Creating a mobile app for an online retail store to enhance the shopping experience.', 'Proposal for E-commerce Mobile App', 'High user engagement and seamless shopping process.', 'Checkout process optimization required.', 12),
  ('Inventory Tracking System', 'Semester 2 2017', 'Building an advanced inventory tracking system for efficient stock management.', 'Proposal for Inventory Tracking System', 'Real-time stock updates and streamlined inventory management.', 'Integration with third-party suppliers needs improvement.', 3),
  ('Healthcare Information System', 'Semester 1 2017', 'Developing a comprehensive healthcare information system for medical institutions.', 'Proposal for Healthcare Information System', 'Efficient patient record management and improved healthcare services.', 'Data synchronization challenges across multiple clinics.', 3),
  ('E-learning Content Management', 'Semester 2 2016', 'Designing a content management system for e-learning platforms.', 'Proposal for E-learning Content Management', 'Effective content organization and distribution for educators.', 'Scalability issues with a growing user base.', 8);


INSERT INTO `clients_organisations` (`client_id`, `org_id`) VALUES
(1, 15),
(2, 2),
(2, 6),
(3, 1),
(4, 1),
(4, 2),
(5, 1),
(6, 7),
(6, 14),
(7, 1),
(8, 1),
(8, 10),
(9, 12),
(10, 8),
(10, 13),
(11, 1),
(12, 5),
(12, 11),
(13, 4),
(14, 3),
(14, 14),
(15, 8),
(15, 9);


INSERT INTO CONTACT_US (name, email, phone_number, message, replied)
VALUES
    ('Sakura Tanaka', 'sakura.tanaka@mail.com', '0412345678', 'I have a question about your products.', TRUE),
    ('Mohammed Ali', 'mohammed.ali@mail.com', '0412345679', 'Please provide more information about your services.', FALSE),
    ('Lan Nguyen', 'lan.nguyen@gmail.com', '0412345680', 'I need technical support.', TRUE),
    ('Elena Petrov', 'elena.petrov@yahoo.net', '0412345681', 'Im interested in a partnership.', FALSE),
    ('Jasmin Patel', 'jasmin.patel@mail.net', '0412345682', 'Please send me a brochure.', TRUE),
    ('Ahmed Khan', 'ahmed.khan@gmail.com', '0412345683', 'I have a billing inquiry.', FALSE),
    ('Aisha Al-Mansoori', 'aisha.al-mansoori@google.com', '0412345684', 'I want to schedule a demo.', TRUE),
    ('Santos Rodriguez', 'santos.rodriguez@mails.com', '0412345685', 'Please call me back.', FALSE),
    ('Ming Li', 'ming.li@mail-us.com', '0412345686', 'Im looking for customer references.', TRUE),
    ('Priya Sharma', 'priya.sharma@yahoo.com', '0412345687', 'I need assistance with my account.', FALSE);

    
INSERT INTO CLIENT_CONTACT_US (client_id, form_id)
VALUES
    (1, 1),    
    (2, 3),    
    (3, 7),    
    (4, 9);    

