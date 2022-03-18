
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

