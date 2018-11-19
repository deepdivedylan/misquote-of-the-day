DROP TABLE IF EXISTS misquote;

CREATE TABLE misquote (
	misquoteId BINARY(16) NOT NULL,
	attribution VARCHAR(64) NOT NULL,
	misquote VARCHAR(255) NOT NULL,
	submitter VARCHAR(64) NOT NULL,
	PRIMARY KEY(misquoteId)
);