-- ============================================
-- Hydrothermal Vent Fauna Database
-- SET08101 Web Technologies Coursework
-- ============================================

-- Drop tables if they exist (for clean re-import)
DROP TABLE IF EXISTS fauna;
DROP TABLE IF EXISTS vents;

-- ============================================
-- Vents Table
-- ============================================
CREATE TABLE vents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(200) NOT NULL,
    type VARCHAR(50) NOT NULL,
    depth_metres INT NOT NULL,
    discovery_year INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Fauna Table
-- ============================================
CREATE TABLE fauna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vent_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(150) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    FOREIGN KEY (vent_id) REFERENCES vents(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Sample Vent Data
-- Data sourced from West Pacific vent biogeography research
-- ============================================
INSERT INTO vents (name, location, type, depth_metres, discovery_year) VALUES
('Manus Basin', 'Bismarck Sea, Papua New Guinea (3.5S, 151.5E)', 'Back-arc basin', 1650, 1985),
('Lau Basin', 'Southwest Pacific, Tonga (20S, 176W)', 'Back-arc basin', 1900, 1989),
('North Fiji Basin', 'Southwest Pacific, Fiji (17S, 173E)', 'Back-arc basin', 2000, 1988),
('Mariana Back-arc', 'Western Pacific, Mariana Islands (18N, 144.5E)', 'Back-arc spreading centre', 3600, 1987),
('Mariana Volcanic Arc', 'Western Pacific, Mariana Islands (21N, 144E)', 'Volcanic arc', 1500, 2003),
('Okinawa Trough', 'East China Sea, Japan (27N, 127E)', 'Back-arc basin', 1400, 1988);

-- ============================================
-- Sample Fauna Data
-- Species names from scientific literature
-- ============================================

-- Manus Basin fauna (vent_id = 1)
INSERT INTO fauna (vent_id, name, scientific_name, description, image_url) VALUES
(1, 'Manus Hairy Snail', 'Alviniconcha hessleri', 'Large gastropod with distinctive hairy periostracum housing chemosynthetic bacteria. Grows up to 6cm and forms dense aggregations near vent openings.', 'images/fauna_images/1/alviniconcha_hessleri.jpg'),

(1, 'Manus Vent Mussel', 'Bathymodiolus manusensis', 'Deep-sea mussel hosting symbiotic bacteria in its gills. Forms extensive beds around hydrothermal vents.', 'images/fauna_images/1/bathymodiolus_manusensis.jpg'), 

(1, 'Manus Vent Crab', 'Austinograea alayseae', 'White blind crab adapted to vent environments. Feeds on bacterial mats and small invertebrates.', 'images/fauna_images/1/austinograea_alayseae.jpg'), 

(1, 'Manus Limpet', 'Olgaconcha tufari', 'Small gastropod living on hard substrates near vents. Grazes on bacterial films.', 'images/fauna_images/1/olgaconcha_tufari.jpg'); 


-- Lau Basin fauna (vent_id = 2)
INSERT INTO fauna (vent_id, name, scientific_name, description, image_url) VALUES
(2, 'Lau Basin Snail', 'Alviniconcha kojimai', 'Hairy snail species endemic to the Lau Basin. Hosts sulphur-oxidising bacterial symbionts.', 'images/fauna_images/2/alviniconcha_kojimai.jpg'),
(2, 'Scaly-foot Snail', 'Chrysomallon squamiferum', 'Remarkable gastropod with iron-mineralised scales on its foot. The only known animal to incorporate iron into its exoskeleton.', 'images/fauna_images/2/chrysomallon_squamiferum.jpg'),
(2, 'Lau Vent Shrimp', 'Rimicaris variabilis', 'Swarming shrimp with bacterial symbionts in enlarged gill chambers. Found in high-temperature vent fluids.', 'images/fauna_images/2/rimicaris_variabilis.jpg'),
(2, 'Lau Tubeworm', 'Lamellibrachia juni', 'Large vestimentiferan tubeworm reaching over 1 metre in length. Hosts chemosynthetic bacteria.', 'images/fauna_images/2/lamellibrachia_juni.jpg');

-- North Fiji Basin fauna (vent_id = 3)
INSERT INTO fauna (vent_id, name, scientific_name, description, image_url) VALUES
(3, 'North Fiji Mussel', 'Bathymodiolus brevior', 'Smaller vent mussel species with thioautotrophic symbionts. Common in diffuse flow areas.', 'images/fauna_images/3/bathymodiolus_brevior.jpg'),
(3, 'Fiji Squat Lobster', 'Munidopsis starmer', 'White squat lobster found around vent peripheries. Opportunistic feeder on vent detritus.', 'images/fauna_images/3/munidopsis_starmer.jpg'),
(3, 'Fiji Polynoid Worm', 'Branchinotogluma segonzaci', 'Scale worm living among mussel beds. Predator on smaller invertebrates.', 'images/fauna_images/3/branchinotogluma_segonzaci.jpg');

-- Mariana Back-arc fauna (vent_id = 4)
INSERT INTO fauna (vent_id, name, scientific_name, description, image_url) VALUES
(4, 'Mariana Vent Snail', 'Provanna variabilis', 'Small provannid gastropod found in diffuse flow habitats. Grazes on bacterial mats.', 'images/fauna_images/4/provanna_variabilis.jpg'),
(4, 'Mariana Hesionid Worm', 'Hesiocaeca hessleri', 'Small polychaete worm living in vent sediments. Deposit feeder.', 'images/fauna_images/4/hesiocaeca_hessleri.jpg'),
(4, 'Mariana Vent Shrimp', 'Alvinocaris chelys', 'Deep-water caridean shrimp with elongated claws. Found in high-temperature zones.', 'images/fauna_images/4/alvinocaris_chelys.jpg'),
(4, 'Mariana Sea Anemone', 'Marianactis bythios', 'Large actiniarian anemone endemic to Mariana vents. Preys on small crustaceans.', 'images/fauna_images/4/marianactis_bythios.jpg');

-- Mariana Volcanic Arc fauna (vent_id = 5)
INSERT INTO fauna (vent_id, name, scientific_name, description, image_url) VALUES
(5, 'Eifuku Snail', 'Provanna fenestrata', 'Provannid gastropod discovered at Northwest Eifuku volcano. Lives near carbon dioxide vents.', 'images/fauna_images/5/provanna_fenestrata.jpg'),
(5, 'Arc Vent Barnacle', 'Neolepas zevinae', 'Stalked barnacle adapted to volcanic vent environments. Filter feeder.', 'images/fauna_images/5/neolepas_zevinae.jpg');


-- Okinawa Trough fauna (vent_id = 6)
INSERT INTO fauna (vent_id, name, scientific_name, description, image_url) VALUES
(6, 'Okinawa Hairy Snail', 'Alviniconcha adamantis', 'Hairy gastropod species found in the Okinawa Trough. Harbours chemosynthetic symbionts.', 'images/fauna_images/6/alviniconcha_adamantis.jpg'),
(6, 'Okinawa Crab', 'Shinkaia crosnieri', 'Distinctive galatheid crab with bacterial filaments on its setae. Also known as the yeti crab.', 'images/fauna_images/6/shinkaia_crosnieri.jpg'),
(6, 'Okinawa Vent Limpet', 'Lepetodrilus nux', 'Small limpet found grazing on bacterial mats near vents.', 'images/fauna_images/6/lepetodrilus_nux.jpg'),
(6, 'Okinawa Vent Shrimp', 'Alvinocaris longirostris', 'Caridean shrimp with elongated rostrum. Found in high-temperature vent areas.', 'images/fauna_images/6/alvinocaris_longirostris.jpg');
