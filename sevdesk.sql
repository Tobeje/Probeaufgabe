-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Jul 2020 um 20:53
-- Server-Version: 10.4.13-MariaDB
-- PHP-Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `sevdesk`
--
CREATE DATABASE IF NOT EXISTS `sevdesk` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sevdesk`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `festgeldkonto`
--

CREATE TABLE `festgeldkonto` (
  `Kontonummer_FK` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Guthaben` double NOT NULL,
  `PIN` char(4) NOT NULL,
  `Zinssatz` double NOT NULL,
  `Letztezahlung` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `festgeldkonto`
--

INSERT INTO `festgeldkonto` (`Kontonummer_FK`, `Name`, `Guthaben`, `PIN`, `Zinssatz`, `Letztezahlung`) VALUES
(1, '4', 22, '1', 2.5, '2020-06-01');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `girokonto`
--

CREATE TABLE `girokonto` (
  `Kontonummer_GK` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Guthaben` double NOT NULL DEFAULT 0,
  `PIN` char(4) NOT NULL,
  `Dispolimit` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `girokonto`
--

INSERT INTO `girokonto` (`Kontonummer_GK`, `Name`, `Guthaben`, `PIN`, `Dispolimit`) VALUES
(1, 'test', -400, '3333', 500);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kreditkarte`
--

CREATE TABLE `kreditkarte` (
  `Kartennummer` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `PIN` char(4) NOT NULL,
  `KreditLimit` double NOT NULL,
  `Guthaben` double NOT NULL,
  `Kontonummer_GK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `kreditkarte`
--

INSERT INTO `kreditkarte` (`Kartennummer`, `Name`, `PIN`, `KreditLimit`, `Guthaben`, `Kontonummer_GK`) VALUES
(2, '11', '1', 500, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nutzer`
--

CREATE TABLE `nutzer` (
  `Kundennummer` int(11) NOT NULL,
  `Nachname` varchar(255) NOT NULL,
  `Vorname` varchar(255) NOT NULL,
  `Geburtsdatum` date NOT NULL,
  `Geschlecht` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `nutzer`
--

INSERT INTO `nutzer` (`Kundennummer`, `Nachname`, `Vorname`, `Geburtsdatum`, `Geschlecht`) VALUES
(1, 'test', 'test', '2020-07-08', 'Männlich'),
(2, 'peter', 'frank', '2020-07-05', 'Weiblich'),
(3, 'Mustermann', 'Max', '2020-07-05', 'Männlich');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nutzerfest`
--

CREATE TABLE `nutzerfest` (
  `Kundennummer` int(11) NOT NULL,
  `Kontonummer_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nutzergiro`
--

CREATE TABLE `nutzergiro` (
  `Kundennummer` int(11) NOT NULL,
  `Kontonummer_GK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `nutzergiro`
--

INSERT INTO `nutzergiro` (`Kundennummer`, `Kontonummer_GK`) VALUES
(2, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `festgeldkonto`
--
ALTER TABLE `festgeldkonto`
  ADD PRIMARY KEY (`Kontonummer_FK`);

--
-- Indizes für die Tabelle `girokonto`
--
ALTER TABLE `girokonto`
  ADD PRIMARY KEY (`Kontonummer_GK`);

--
-- Indizes für die Tabelle `kreditkarte`
--
ALTER TABLE `kreditkarte`
  ADD PRIMARY KEY (`Kartennummer`),
  ADD KEY `Kontonummer_GK` (`Kontonummer_GK`);

--
-- Indizes für die Tabelle `nutzer`
--
ALTER TABLE `nutzer`
  ADD PRIMARY KEY (`Kundennummer`);

--
-- Indizes für die Tabelle `nutzerfest`
--
ALTER TABLE `nutzerfest`
  ADD PRIMARY KEY (`Kundennummer`,`Kontonummer_FK`),
  ADD KEY `Kontonummer_FK` (`Kontonummer_FK`);

--
-- Indizes für die Tabelle `nutzergiro`
--
ALTER TABLE `nutzergiro`
  ADD PRIMARY KEY (`Kundennummer`,`Kontonummer_GK`),
  ADD KEY `Kontonummer_GK` (`Kontonummer_GK`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `festgeldkonto`
--
ALTER TABLE `festgeldkonto`
  MODIFY `Kontonummer_FK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `girokonto`
--
ALTER TABLE `girokonto`
  MODIFY `Kontonummer_GK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `kreditkarte`
--
ALTER TABLE `kreditkarte`
  MODIFY `Kartennummer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `nutzer`
--
ALTER TABLE `nutzer`
  MODIFY `Kundennummer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `kreditkarte`
--
ALTER TABLE `kreditkarte`
  ADD CONSTRAINT `kreditkarte_ibfk_1` FOREIGN KEY (`Kontonummer_GK`) REFERENCES `girokonto` (`Kontonummer_GK`);

--
-- Constraints der Tabelle `nutzerfest`
--
ALTER TABLE `nutzerfest`
  ADD CONSTRAINT `nutzerfest_ibfk_1` FOREIGN KEY (`Kundennummer`) REFERENCES `nutzer` (`Kundennummer`),
  ADD CONSTRAINT `nutzerfest_ibfk_2` FOREIGN KEY (`Kontonummer_FK`) REFERENCES `festgeldkonto` (`Kontonummer_FK`);

--
-- Constraints der Tabelle `nutzergiro`
--
ALTER TABLE `nutzergiro`
  ADD CONSTRAINT `nutzergiro_ibfk_1` FOREIGN KEY (`Kundennummer`) REFERENCES `nutzer` (`Kundennummer`),
  ADD CONSTRAINT `nutzergiro_ibfk_2` FOREIGN KEY (`Kontonummer_GK`) REFERENCES `girokonto` (`Kontonummer_GK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
