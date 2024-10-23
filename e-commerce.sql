-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2024 a las 00:48:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `e-commerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(11, 'Skin Care'),
(12, 'Hair Care'),
(13, 'Body Care'),
(14, 'Facial Care'),
(15, 'Hand and Foot Care'),
(16, 'Makeup'),
(17, 'Fragrances');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `num_card` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status_venta` varchar(50) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `name`, `email`, `phone`, `num_card`, `total`, `order_date`, `status_venta`, `metodo_pago`) VALUES
(48, '6N197265C8939745E', 'John Doe', 'sb-95hqj31592580@personal.example.com', '', '', 171.44, '2024-07-30 18:40:12', 'pagado', 'paypal'),
(49, '', 'Joseph Aaron Alarcon Camarillo', 'josephcamarillo112@gmail.com', '5583947980', '454545454545', 171.44, '2024-07-30 20:40:21', 'no pagado', ''),
(50, '46949713N8346225E', 'John Doe', 'sb-95hqj31592580@personal.example.com', '', '', 172.07, '2024-07-30 21:44:43', 'pagado', 'paypal'),
(51, '0KJ44967US5877001', 'John Doe', 'sb-95hqj31592580@personal.example.com', '', '', 172.07, '2024-07-30 21:50:20', 'pagado', 'paypal'),
(52, '9VL331538J313502A', 'John Doe', 'sb-95hqj31592580@personal.example.com', '', '', 269.70, '2024-07-30 22:41:34', 'pagado', 'paypal'),
(53, '', 'Joseph Aaron Alarcon Camarillo', 'josephcamarillo112@gmail.com', '5583947980', '343434343434', 269.70, '2024-07-31 00:41:44', 'no pagado', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total`) VALUES
(81, 48, 22, 'Reloj', 2, 34.00, 69.78),
(82, 48, 29, 'sgs', 1, 33.00, 33.70),
(83, 48, 32, 'casa', 2, 33.00, 67.96),
(84, 49, 22, 'Reloj', 2, 34.89, 69.78),
(85, 49, 29, 'sgs', 1, 33.70, 33.70),
(86, 49, 32, 'casa', 2, 33.98, 67.96),
(87, 50, 29, 'sgs', 2, 33.00, 67.40),
(88, 50, 22, 'Reloj', 3, 34.00, 104.67),
(89, 51, 29, 'sgs', 2, 33.00, 67.40),
(90, 51, 22, 'Reloj', 3, 34.00, 104.67),
(91, 52, 33, 'Shade Llumene', 1, 89.00, 89.90),
(92, 52, 34, 'Creme Care', 1, 89.00, 89.90),
(93, 52, 45, 'Aqua Alegoria', 1, 89.00, 89.90),
(94, 53, 33, 'Shade Llumene', 1, 89.90, 89.90),
(95, 53, 34, 'Creme Care', 1, 89.90, 89.90),
(96, 53, 45, 'Aqua Alegoria', 1, 89.90, 89.90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `paypal_transaction_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`, `product_image`, `category_id`) VALUES
(33, 'Shade Llumene', 'Shade Llumene - Cafe/Carmín/Beige', 89.90, 'archivos/33.jpg', 16),
(34, 'Creme Care', 'Creme Care FPS50 Nacar-Rise', 89.90, 'archivos/34.jpg', 14),
(35, 'Roll Face', 'Roll Face White - Quartz', 39.90, 'archivos/35.jpg', 14),
(36, 'Shaving Cream', 'Shaving Cream /legs ', 24.90, 'archivos/36.jpg', 13),
(41, 'Hair Cre Kit', 'Hair Cre Kit /Brush / Conditioner/ Fragrance', 89.90, 'archivos/41.jpg', 12),
(42, 'vitamin varnish for feet', 'vitamin varnish for feet / Hands', 33.90, 'archivos/42.jpg', 15),
(43, 'Foot towel', 'Foot towel / Body', 33.90, 'archivos/43.jpg', 15),
(44, 'Serum Facial', 'Serum Facial/ Recontruct /Relive', 99.90, 'archivos/44.jpg', 11),
(45, 'Aqua Alegoria', 'Aqua Alegoria/ Fragance MEN', 89.90, 'archivos/45.jpg', 17),
(46, 'The Queen ', 'The Queen/ Fragence for She', 89.90, 'archivos/46.jpg', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `email`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$10$bPv0s8LAdUYdlScU.U0wU.vny/ZZBd4eXc1m84kDPNqm2eisjmo/q', '', '', '2024-07-29 20:25:10', '2024-07-29 20:25:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
