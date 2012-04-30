SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `proposalSystem` DEFAULT CHARACTER SET utf8 ;
USE `proposalSystem` ;

-- -----------------------------------------------------
-- Table `proposalSystem`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `proposalSystem`.`users` (
  `UID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Username` VARCHAR(45) NOT NULL ,
  `Email` VARCHAR(45) NOT NULL ,
  `Password` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`UID`) ,
  UNIQUE INDEX `UID_UNIQUE` (`UID` ASC) ,
  UNIQUE INDEX `Username_UNIQUE` (`Username` ASC) ,
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proposalSystem`.`categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `proposalSystem`.`categories` (
  `idcategories` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NOT NULL ,
  `Abbr` VARCHAR(3) NOT NULL ,
  PRIMARY KEY (`idcategories`) ,
  UNIQUE INDEX `idcategories_UNIQUE` (`idcategories` ASC) ,
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC) ,
  UNIQUE INDEX `Abbr_UNIQUE` (`Abbr` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proposalSystem`.`proposals`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `proposalSystem`.`proposals` (
  `idproposals` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Proposal_ID` TINYINT UNSIGNED NOT NULL ,
  `Action` TEXT NOT NULL ,
  `Date` INT UNSIGNED NOT NULL ,
  `Summary` LONGTEXT NOT NULL ,
  `is_rev` TINYINT(1) NOT NULL ,
  `parent_ID` INT UNSIGNED NULL ,
  `users_UID` INT UNSIGNED NOT NULL ,
  `categories_idcategories` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idproposals`) ,
  UNIQUE INDEX `idproposals_UNIQUE` (`idproposals` ASC) ,
  INDEX `fk_proposals_users` (`users_UID` ASC) ,
  INDEX `fk_proposals_categories1` (`categories_idcategories` ASC) ,
  CONSTRAINT `fk_proposals_users`
    FOREIGN KEY (`users_UID` )
    REFERENCES `proposalSystem`.`users` (`UID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proposals_categories1`
    FOREIGN KEY (`categories_idcategories` )
    REFERENCES `proposalSystem`.`categories` (`idcategories` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
