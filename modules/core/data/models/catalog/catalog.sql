
CREATE SCHEMA IF NOT EXISTS `digitalbox3_test` DEFAULT CHARACTER SET utf8 ;
USE `digitalbox3_test` ;

-- -----------------------------------------------------
-- Table `digitalbox3_test`.`catalog_catalog`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `digitalbox3_test`.`catalog_catalog` (
  `clgID` INT(10) NOT NULL AUTO_INCREMENT ,
  `clgName` VARCHAR(256) CHARACTER SET 'utf8' NOT NULL ,
  `clgOrdinal` INT(10) NULL DEFAULT NULL ,
  `clgUID` VARCHAR(256) CHARACTER SET 'utf8' NULL DEFAULT NULL ,
  `clgGID` INT(10) NOT NULL DEFAULT '0' ,
  `clgAdminLevel` INT(10) NOT NULL ,
  `clgParentID` INT(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`clgID`) ,
  INDEX `fk_parent_catalog` (`clgParentID` ASC) ,
  CONSTRAINT `fk_parent_catalog`
    FOREIGN KEY (`clgParentID` )
    REFERENCES `digitalbox3_test`.`catalog_catalog` (`clgID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `digitalbox3_test`.`catalog_admin`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `digitalbox3_test`.`catalog_admin` (
  `admID` INT NOT NULL ,
  `admUID` VARCHAR(256) CHARACTER SET 'utf8' NOT NULL ,
  `admCatalogID` INT(10) NOT NULL ,
  INDEX `fk_admin_catalog1` (`admCatalogID` ASC) ,
  PRIMARY KEY (`admID`) ,
  CONSTRAINT `fk_admin_catalog1`
    FOREIGN KEY (`admCatalogID` )
    REFERENCES `digitalbox3_test`.`catalog_catalog` (`clgID` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `digitalbox3_test`.`catalog_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `digitalbox3_test`.`catalog_content` (
  `cntID` INT(10) NOT NULL AUTO_INCREMENT ,
  `cntOrdinal` INT(10) NULL DEFAULT '0' ,
  `cntName` VARCHAR(256) CHARACTER SET 'utf8' NOT NULL ,
  `cntAuthor` VARCHAR(256) CHARACTER SET 'utf8' NULL DEFAULT NULL ,
  `cntKeywords` VARCHAR(256) CHARACTER SET 'utf8' NULL DEFAULT NULL ,
  `cntTimeCreated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `cntTimeUpdated` TIMESTAMP NULL DEFAULT NULL ,
  `cntTimeVisited` TIMESTAMP NULL DEFAULT NULL ,
  `cntPointValue` INT(10) NOT NULL DEFAULT '0' ,
  `cntUID` VARCHAR(256) CHARACTER SET 'utf8' NOT NULL ,
  `cntVisitCount` INT(10) NOT NULL DEFAULT '0' ,
  `cntAdminLevel` INT(10) NULL DEFAULT NULL ,
  `cntVisitLevel` INT(10) NOT NULL DEFAULT '0' ,
  `cntCatalogID` INT(10) NOT NULL ,
  PRIMARY KEY (`cntID`) ,
  INDEX `fk_content_catalog1` (`cntCatalogID` ASC) ,
  CONSTRAINT `fk_content_catalog1`
    FOREIGN KEY (`cntCatalogID` )
    REFERENCES `digitalbox3_test`.`catalog_catalog` (`clgID` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
