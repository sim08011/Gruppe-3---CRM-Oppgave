-- MySQL Script generated by MySQL Workbench
-- Tue Mar  5 09:41:22 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema crm_database
-- -----------------------------------------------------
-- Database for CRM-oppgaven - Gruppe 3

-- -----------------------------------------------------
-- Schema crm_database
--
-- Database for CRM-oppgaven - Gruppe 3
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `crm_database` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `crm_database` ;

-- -----------------------------------------------------
-- Table `crm_database`.`postSted`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_database`.`postSted` (
  `postnummer` VARCHAR(4) NOT NULL,
  `poststed` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`postnummer`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm_database`.`kunde`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_database`.`kunde` (   
  `kundeID` INT NOT NULL AUTO_INCREMENT,   
  `navn` VARCHAR(45) NOT NULL,   
  `epost` VARCHAR(100) NOT NULL,   
  `tlf` VARCHAR(12) NOT NULL,   
  `postSted_postnummer` VARCHAR(4) NOT NULL,   
  PRIMARY KEY (`kundeID`),   
  INDEX `fk_kunde_postSted1_idx` (`postSted_postnummer`),   
  CONSTRAINT `fk_kunde_postSted1`     
    FOREIGN KEY (`postSted_postnummer`)     
    REFERENCES `crm_database`.`postSted` (`postnummer`)     
    ON DELETE NO ACTION     
    ON UPDATE NO ACTION
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm_database`.`avdeling`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_database`.`avdeling` (
  `avdelingID` INT NOT NULL AUTO_INCREMENT,
  `stillingNavn` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`avdelingID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm_database`.`stilling`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_database`.`stilling` (
  `stillingID` INT NOT NULL AUTO_INCREMENT,
  `stillingNavn` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`stillingID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `crm_database`.`kontaktperson`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_database`.`kontaktperson` (
  `kontaktpersonID` INT NOT NULL AUTO_INCREMENT,
  `fornavn` VARCHAR(45) NOT NULL,
  `etternavn` VARCHAR(45) NOT NULL,
  `kunde_kundeID` INT NOT NULL,
  `avdeling_avdelingID` INT NOT NULL,
  `stilling_stillingID` INT NOT NULL,
  `tlf` VARCHAR(12) NOT NULL,
  `epost` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`kontaktpersonID`),
  INDEX `fk_kontaktperson_kunde_idx` (`kunde_kundeID` ASC) ,
  INDEX `fk_kontaktperson_avdeling1_idx` (`avdeling_avdelingID` ASC) ,
  INDEX `fk_kontaktperson_stilling1_idx` (`stilling_stillingID` ASC) ,
  CONSTRAINT `fk_kontaktperson_kunde`
    FOREIGN KEY (`kunde_kundeID`)
    REFERENCES `crm_database`.`kunde` (`kundeID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_kontaktperson_avdeling1`
    FOREIGN KEY (`avdeling_avdelingID`)
    REFERENCES `crm_database`.`avdeling` (`avdelingID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_kontaktperson_stilling1`
    FOREIGN KEY (`stilling_stillingID`)
    REFERENCES `crm_database`.`stilling` (`stillingID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
