INSERT INTO `payment` VALUES (1, 112, "Tobi's Table",1),(4, 113, "White Thunder",4),(10, 114, "Brown Bear", 2);

INSERT INTO `playlist` VALUES (1,1),(1,2),(1,3),(1,10),(1,11),(1,12),(1,13),(1,22),(1,23),(1,24),(2,14),(2,15);

INSERT INTO `playlist_name` VALUES (1,'House Hits'),(2,'Labor Day Weekend');

INSERT INTO `queue` VALUES (1,0,112,0,'0000-00-00 00:00:00'),(2,0,112,0,'0000-00-00 00:00:00'),(3,0,112,0,'0000-00-00 00:00:00'),(10,0,112,0,'0000-00-00 00:00:00'),(11,0,112,0,'0000-00-00 00:00:00'),(12,0,112,0,'0000-00-00 00:00:00'),(13,0,112,0,'0000-00-00 00:00:00'),(14,0,112,1,'0000-00-00 00:00:00'),(15,0,112,1,'0000-00-00 00:00:00'),(22,0,113,0,'0000-00-00 00:00:00'),(23,0,112,0,'0000-00-00 00:00:00'),(24,0,114,0,'0000-00-00 00:00:00');

INSERT INTO `song` VALUES (1,'Are You Feelin It (Feat. Elephant Man)','Teddybears','Soft Machine\r','Unknown',200,0,'',1),(3,'Dead End Friends','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(4,'Reptiles','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(5,'Caligulove','Them Crooked Vultures','Them Crooked Vultures\r','Unknown',200,0,'',1),(6,'White Sky','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(7,'Taxi Cab','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(8,'Giant (Bonus Track)','Vampire Weekend','Contra (Bonus Track Version)\r','Unknown',200,0,'',1),(10,'M79','Vampire Weekend','Vampire Weekend\r','Unknown',200,0,'',1),(11,'Get Free','The Vines','Highly Evolved\r','Unknown',200,0,'',1),(12,'Atmos','The Vines','Vision Valley\r','Unknown',200,0,'',1),(13,'TV Pro','The Vines','Winning Days\r','Unknown',200,0,'',1),(14,'Passive Manipulation','The White Stripes','Get Behind Me Satan\r','Unknown',200,0,'',1);

INSERT INTO `constants` VALUES ("clear_queue",1),("request_type",1),("priceOfRequest", 25 -- (in cents)
);