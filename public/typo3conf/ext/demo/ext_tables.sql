CREATE TABLE tx_demo_domain_model_entity (
	title varchar(64) DEFAULT '' NOT NULL,
	deleted tinyint(1) DEFAULT '0' NOT NULL,

	KEY title (title)
);
