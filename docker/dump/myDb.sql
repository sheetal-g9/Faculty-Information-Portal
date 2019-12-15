SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

create table Faculty (
	-- faculty_id int not null auto_increment,
	faculty_id varchar(100) not null,
	faculty_password varchar(50),    
	faculty_name varchar(100),    
	faculty_email varchar(100),    
	faculty_department varchar(100),    
	faculty_designation varchar(100),    
	faculty_website varchar(100),    
	faculty_research_fields text,    
	constraint faculty_pk primary key (faculty_id)
	-- constraint faculty_pk primary key (faculty_email)
	);
create table Publication (    
	publication_id int not null auto_increment,
	-- publication_id varchar(50),
	title text,
	research_fields text,
	description text,
	citations text,
	type varchar(50),
	pages varchar(50),
	publication_date date,
	constraint publication_pk primary key (publication_id)
	-- constraint publication_pk primary key (title)
	);
create table Journal_Publication (    
	publication_id int not null,
	-- publication_id varchar(50),    
	journal_name varchar(100),    
	volume varchar(50),
	no varchar(50),
	constraint journal_publication_pk primary key (publication_id),    
	constraint journal_publication_fk foreign key (publication_id)    
	references Publication(publication_id)
	);

create table Conference_Publication (    
	publication_id int not null,
	-- publication_id varchar(50),    
	organisation varchar(100),    
	location varchar(100),    
	constraint conference_publication_pk primary key (publication_id),    
	constraint conference_publication_fk foreign key (publication_id)    
	references Publication(publication_id)
	);

create table Publication_Faculty (
	publication_id int not null,
	-- publication_id varchar(50),    
	-- faculty_id int not null,
	faculty_id varchar(100) not null,    
	role varchar(100),    
	constraint publication_faculty_pk primary key (publication_id, faculty_id),    
	constraint publication_faculty_fk_1 foreign key (publication_id)    
	references Publication(publication_id),    
	constraint publication_faculty_fk_2 foreign key (faculty_id)    
	references Faculty(faculty_id)
	);

create table Project (    
	project_id int not null auto_increment,
	-- project_id varchar(50),    
	title text,    
	description text,
	start_date date,    
	end_date date,    
	funding_agency varchar(100),    
	budget int unsigned,    
	constraint project_pk primary key (project_id)
	);

create table Project_Faculty (    
	project_id int not null,
	-- project_id varchar(50),
	-- faculty_id int not null,
	faculty_id varchar(100),
	project_designation varchar(50),    
	constraint project_faculty_pk primary key (project_id, faculty_id),    
	constraint project_faculty_fk_1 foreign key (project_id)    
	references Project(project_id),
	constraint project_faculty_fk_2 foreign key (faculty_id)
	references Faculty(faculty_id)
	);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
