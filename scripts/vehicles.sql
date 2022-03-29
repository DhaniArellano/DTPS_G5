
--
-- Base de datos: `db_vehicles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehicles`
--

CREATE TABLE `vehicles` (
  `code` int NOT NULL,
  `type` text NOT NULL,
  `model` text NOT NULL,
  `license_plate` text NOT NULL,
  `color` text NOT NULL,
  `num_passengers` text NOT NULL,
  `photo` text DEFAULT NULL,
  `fuel_type` text NOT NULL,
  PRIMARY KEY(code)
) ENGINE=InnoDB DEFAULT;
ALTER TABLE `vehicles` CHANGE `model` `model` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `vehicles` CHANGE `license_plate` `license_plate` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `vehicles` CHANGE `color` `color` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `vehicles` CHANGE `num_passengers` `num_passengers` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `vehicles` CHANGE `photo` `photo` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `vehicles` CHANGE `fuel_type` `fuel_type` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

