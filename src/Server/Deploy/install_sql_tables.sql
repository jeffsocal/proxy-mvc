-- 
-- Copyright (2018) SoCal Bioinformatics Inc. All rights reserved.
-- This script is the confidential and proprietary product
-- of SoCal Bioinformatics Inc. Any Unauthorized reproduction or
-- transfer of the contents herein is strictly prohibited.
-- 
-- AUTH: Jeff Jones | SoCal Bioinformatics Inc
-- DATE: 2018.03.28
-- OWNER: SoCal Bioinformatics Inc

CREATE DATABASE `authorizations` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE authorizations;

SET autocommit=0; source sql/authorizations_credentials.sql; COMMIT;
SET autocommit=0; source sql/authorizations_invites.sql; COMMIT;
SET autocommit=0; source sql/authorizations_logins.sql; COMMIT;
