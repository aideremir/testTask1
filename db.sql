--
-- Table structure for table `tree_menu`
--

CREATE TABLE `tree_menu` (
  `node_id` int(6) NOT NULL,
  `parent_id` int(6) NOT NULL,
  `Name` varchar(35) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tree_menu`
--

INSERT INTO `tree_menu` (`node_id`, `parent_id`, `Name`) VALUES
(1, 0, 'Category 1'),
(2, 0, 'Category 2'),
(3, 0, 'Category 3'),
(4, 1, 'One'),
(5, 1, 'Two'),
(6, 2, 'Just one category'),
(7, 2, 'Cars'),
(8, 7, 'Mazda'),
(9, 7, 'Renault'),
(10, 8, 'MX-03'),
(11, 8, 'MX-04'),
(12, 9, 'Sedan'),
(13, 9, 'Cabrio'),
(14, 12, 'Laguna'),
(15, 13, 'Megane Coupé'),
(16, 5, 'zomg'),
(17, 5, 'wtf'),
(18, 3, 'Test 1'),
(19, 3, 'Test 2'),
(22, 3, 'Test 4'),
(23, 3, 'Test 5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tree_menu`
--
ALTER TABLE `tree_menu`
  ADD PRIMARY KEY (`node_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tree_menu`
--
ALTER TABLE `tree_menu`
  MODIFY `node_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;