CREATE TABLE primescraper.series
(
season int,
episode int,
url varchar(100),
name varchar(100)
);
CREATE TABLE primescraper.series_data
(
seasons int,
episodes int
);
CREATE TABLE primescraper.sources
(
id int NOT NULL AUTO_INCREMENT,
domain varchar(50),
preference int,
type varchar(5)
);