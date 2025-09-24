-- Briscola Menu SQL (Food + Key Combos / Kids / Selected After-Dinner & N/A drinks)
-- Source: 2024-BRISCOLA-MENU-A3.pdf
-- Currency: AUD
CREATE DATABASE IF NOT EXISTS Giani;

DROP TABLE IF EXISTS menu_items;

CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category        VARCHAR(64) NOT NULL,             -- e.g., 'Pane', 'Starters', 'Pasta', 'Risotto', 'Secondi', 'Contorni', 'Dolci', 'Combos', 'Kids', 'After Dinner', 'Non-Alcoholic'
    subcategory     VARCHAR(64),                      -- optional finer grouping
    item_name       VARCHAR(200) NOT NULL,           -- item title
    description     TEXT,                             -- menu description
    dietary_tags    VARCHAR(100),                     -- e.g., 'vgn', 'v', 'gf', 'df', 'vgn*', 'df*', 'gf*'
    variant         VARCHAR(64),                      -- size or variant (e.g., 'small', 'large', 'sml', 'med', 'gf', 'duo', 'trio', 'entrée', 'main', 'glass', 'jug')
    price           DECIMAL(10,2) NOT NULL,           -- price in AUD
    currency_code   CHAR(3) NOT NULL DEFAULT 'AUD',
    notes           TEXT
);

-- =====================
-- PANE / BREAD
-- =====================
INSERT INTO menu_items (category, item_name, description, dietary_tags, variant, price, notes) VALUES
('Pane', 'Pane di Casa', 'Warm Italian bread / EVO oil / aged balsamic', 'vgn', 'small', 9.00, NULL),
('Pane', 'Pane di Casa', 'Warm Italian bread / EVO oil / aged balsamic', 'vgn', 'large', 12.00, NULL),
('Pane', 'Garlic Bread', 'Italian bread w/ garlic butter & parsley', 'vgn', 'small', 9.00, NULL),
('Pane', 'Garlic Bread', 'Italian bread w/ garlic butter & parsley', 'vgn', 'large', 12.00, NULL),
('Pane', 'Anchovy Bread', 'Italian bread w/ garlic butter / anchovies / sun-dried tomato & parsley', NULL, 'small', 12.00, NULL),
('Pane', 'Anchovy Bread', 'Italian bread w/ garlic butter / anchovies / sun-dried tomato & parsley', NULL, 'large', 15.00, NULL),
('Pane', 'Pizza Bread (rosemary & sea salt)', 'Stone baked pizza w/ rosemary & sea salt', 'vgn', 'sml', 9.00, NULL),
('Pane', 'Pizza Bread (rosemary & sea salt)', 'Stone baked pizza w/ rosemary & sea salt', 'vgn', 'med', 12.00, NULL),
('Pane', 'Pizza Bread (rosemary & sea salt)', 'Stone baked pizza w/ rosemary & sea salt', 'vgn', 'gf', 16.50, 'Gluten free base'),
('Pane', 'Pizza Bread (mozzarella & garlic butter)', 'Stone baked pizza w/ mozzarella & garlic butter', 'v', 'sml', 12.00, NULL),
('Pane', 'Pizza Bread (mozzarella & garlic butter)', 'Stone baked pizza w/ mozzarella & garlic butter', 'v', 'med', 15.00, NULL),
('Pane', 'Pizza Bread (mozzarella & garlic butter)', 'Stone baked pizza w/ mozzarella & garlic butter', 'v', 'gf', 19.50, 'Gluten free base');

-- =====================
-- STUZZICHINI / STARTERS & ENTREES
-- =====================
INSERT INTO menu_items (category, item_name, description, dietary_tags, price, notes) VALUES
('Starters', 'Warmed Olives', 'Italian olives / almonds / warm EVO oil…served w/ pane di casa', 'vgn', 15.00, NULL),
('Starters', 'Antipasto Board', 'Salume / prosciutto / mortadella / giardiniera…served w/ pane di casa', NULL, 29.00, 'Serves 2–4 ppl'),
('Starters', 'Bruschetta', 'Toasted pane di casa / whipped ricotta / cherry tomato / basil / balsamic & fig glaze', 'v; vgn*', 16.00, NULL),
('Starters', 'Arancini', 'Crumbed risotto balls / porcini mushroom / fontina / tomato & roasted capsicum salsina', 'v', 21.00, NULL),
('Starters', 'Calamaretti', 'Sea salt calamari / lemon / rocket / gorgonzola maionese', 'gf', 22.00, 'Add chips +$6'),
('Starters', 'Polpette', 'Veal & pork meatballs / napoli sugo / shaved parmigiano', NULL, 18.00, 'As a pasta +$12');

-- Gamberoni (two sizes)
INSERT INTO menu_items (category, item_name, description, dietary_tags, variant, price) VALUES
('Starters', 'Gamberoni', 'King prawns / garlic / fresh chilli / brandy / macchiato sugo / served on fregola', NULL, 'entrée', 25.00),
('Starters', 'Gamberoni', 'King prawns / garlic / fresh chilli / brandy / macchiato sugo / served on fregola', NULL, 'main', 34.00);

-- =====================
-- PASTA & GNOCCHI
-- =====================
INSERT INTO menu_items (category, item_name, description, dietary_tags, price, notes) VALUES
('Pasta', 'Linguine alla Norma', 'Grilled eggplant / basil / garlic / spicy arrabbiata sugo / fresh ricotta', 'v; vgn*', 27.00, NULL),
('Pasta', 'Spaghetti alla Carbonara', 'Pancetta / onion / garlic / pecorino / egg yolk / cream / black pepper', NULL, 28.00, NULL),
('Pasta', 'Casareccia Alibrandi', 'Chicken / pancetta / garlic / brandy macchiato sugo / shaved parmigiano', NULL, 29.00, NULL),
('Pasta', 'Pappardelle al Ragu', 'Egg ribbon pasta / three meat ragu / shaved parmigiano / basil', 'df*', 32.00, NULL),
('Pasta', 'Linguine di Mare', 'King prawns / scallops / mussels / garlic / chilli / cherry tomato', 'df', 37.00, 'Choose: olive oil or napoli sugo'),
('Pasta', 'Ravioli con Zucca', 'Pumpkin & ricotta ravioli / burnt sage butter / shaved parmigiano / crushed amaretti', 'v', 32.00, NULL),
('Pasta', 'Gnocchi Gorgonzola', 'Gorgonzola / mushroom / baby spinach / cream / shaved parmigiano / toasted walnuts', 'v', 30.00, NULL),
('Pasta', 'Gnocchi Bolognese', 'Slow cooked three meat ragu / shaved parmigiano / basil', 'df*', 35.00, NULL);

-- =====================
-- RISOTTO (GF)
-- =====================
INSERT INTO menu_items (category, item_name, description, dietary_tags, price) VALUES
('Risotto', 'Risotto ai Funghi', 'Mushroom / porcini / sun-dried tomato / baby spinach / balsamic / napoli sugo', 'vgn; gf', 28.00),
('Risotto', 'Risotto Lino', 'Milk-fed veal strips / porcini mushroom / grilled eggplant / shaved parmigiano / truffle oil', 'gf', 32.00),
('Risotto', 'Risotto Nicola', 'King prawns / baby peas / mascarpone / napoli sugo', 'gf', 35.00);

-- =====================
-- SECONDI / MAINS
-- =====================
INSERT INTO menu_items (category, item_name, description, dietary_tags, price, notes) VALUES
('Secondi', 'Barramundi in Bianco', 'Seared barramundi / salmoriglio sauce / cherry tomato / green beans / served w/ fregola', 'df*', 36.00, NULL),
('Secondi', 'Barramundi Puttanesca', 'Seared barramundi / napoli sugo / anchovy / chilli / olives / baby capers / served w/ fregola', 'df', 36.00, NULL),
('Secondi', 'Pollo al Limone', 'Chicken breast / lemon / garlic / baby capers / white wine / roast veg & chats', 'df*', 36.00, NULL),
('Secondi', 'Pollo con Gamberi', 'Chicken breast / king prawns / garlic / chilli / brandy macchiato sugo / roast veg & chats', NULL, 45.00, NULL),
('Secondi', 'Vitello Boscaiola', 'Crumbed milk-fed veal w/ pancetta, mushroom & garlic cream sauce / roast veg & chats', NULL, 43.00, NULL),
('Secondi', 'Saltimbocca Romana', 'Milk-fed veal medallions / prosciutto / sage / garlic / white wine / roast veg & chats', 'df*', 48.00, NULL),
('Secondi', 'Add King Prawns (addon)', 'Add prawns to any meal', NULL,  NULL, 'Add-on +$8');  -- price encoded in notes

-- =====================
-- CONTORNI / SIDES & SALADS
-- =====================
INSERT INTO menu_items (category, item_name, description, dietary_tags, price, notes) VALUES
('Contorni', 'Patatine', 'Straight cut chips served w/ gorgonzola maionese or ketchup', 'v; df*', 12.00, NULL),
('Contorni', 'Rucola', 'Rocket salad / shaved pecorino / red onion / toasted walnuts / pear / balsamic glaze', 'v; df*', 15.00, NULL),
('Contorni', 'Caprese di Burrata', 'Burrata / heirloom tomatoes / basil / EVO oil / balsamic glaze', 'v', 24.00, NULL),
('Contorni', 'Fagiolini', 'Sauteed green beans / baby chat potato / cinzano rosso / garlic butter', 'vgn', 18.00, NULL);

-- =====================
-- DOLCI / DESSERT
-- =====================
INSERT INTO menu_items (category, item_name, description, dietary_tags, variant, price) VALUES
('Dolci', 'Gelato & Sorbetto', 'Selection: Belgian chocolate / roasted almond / zabaglione / vanilla / lemon sorbet', 'gf; df (sorbet)', 'duo', 13.00),
('Dolci', 'Gelato & Sorbetto', 'Selection: Belgian chocolate / roasted almond / zabaglione / vanilla / lemon sorbet', 'gf; df (sorbet)', 'trio', 16.00);

INSERT INTO menu_items (category, item_name, description, dietary_tags, price) VALUES
('Dolci', 'Tiramisu', 'Savoiardi / zabaglione / mascarpone / espresso / marsala', NULL, 17.00),
('Dolci', 'Pannacotta al Cioccolato', 'Dark chocolate / chocolate soil / berry compote', 'gf', 15.00),
('Dolci', 'Pistachio Crème Brulee', 'Pistachio & vanilla bean served w/ crostoli', 'gf*', 15.00),
('Dolci', 'Torta alla Ricotta', 'Nonna’s lemon ricotta cake', 'gf', 13.00),
('Dolci', 'Ferrero Rocher Calzone', 'Folded pizza w/ nutella / mascarpone / toasted hazelnuts / rice crisps s/w vanilla ice cream', NULL, 24.00),
('Dolci', 'Formaggi (small)', 'Cheese board: gorgonzola / provolone dolce / lavosh / fig jam / fresh pear', NULL, 16.00),
('Dolci', 'Formaggi (large)', 'Cheese board: gorgonzola / provolone dolce / lavosh / fig jam / fresh pear', NULL, 30.00);

-- =====================
-- COMBOS / LUNCH
-- =====================
INSERT INTO menu_items (category, item_name, description, price, notes) VALUES
('Combos', 'Lunch Espresso Combo', 'Includes a glass of house wine or soft drink. Choice of Panini / Pasta Original / Pizza Classic.', 25.00, 'See menu for selections');

-- =====================
-- KIDS
-- =====================
INSERT INTO menu_items (category, item_name, description, price, notes) VALUES
('Kids', 'Bambini Meal', 'Kids 12 & under: choose a pizza or pasta + ice cream', 17.00, 'Add gnocchi +$3; swap for gelato +$5'),
('Kids', 'Hot Chips (Kids)', 'With tomato sauce', 6.00, 'Large size available at $12');

-- Large variant for Hot Chips (Kids)
INSERT INTO menu_items (category, item_name, description, variant, price) VALUES
('Kids', 'Hot Chips (Kids)', 'With tomato sauce', 'large', 12.00);

-- =====================
-- AFTER DINNER (Affogato & Shots)
-- =====================
INSERT INTO menu_items (category, item_name, description, price) VALUES
('After Dinner', 'Affogato', "Zabaglione gelato 'drowned' in espresso", 10.00),
('After Dinner', 'Affogato Liquore', 'Affogato with choice of frangelico, nocello, amaretto, or local caramel vodka', 19.00),
('After Dinner', 'Affogato Limoncello', 'Lemon sorbet & limoncello (no coffee)', 15.00),
('After Dinner', 'Galliano Hot Shot', 'Vanilla galliano liqueur / espresso / whipped cream', 12.00);

-- =====================
-- NON-ALCOHOLIC & MOCKTAILS (Selected)
-- =====================
INSERT INTO menu_items (category, item_name, description, price, notes) VALUES
('Non-Alcoholic', 'San Bitter Spritz', 'Orange aperitif + tonic', 12.00, NULL);

INSERT INTO menu_items (category, item_name, description, variant, price, notes) VALUES
('Non-Alcoholic', 'Virgin Mojito', 'Passionfruit + ginger ale + lime + mint', 'glass', 13.00, NULL),
('Non-Alcoholic', 'Virgin Mojito', 'Passionfruit + ginger ale + lime + mint', 'jug', 45.00, NULL),
('Non-Alcoholic', 'Sooshi-Mango', 'Mango + orange juice + orange bitters + grenadine', 'glass', 13.00, NULL),
('Non-Alcoholic', 'Sooshi-Mango', 'Mango + orange juice + orange bitters + grenadine', 'jug', 45.00, NULL);

-- Notes:
-- • Pizzas, full drinks/wine lists are omitted here because explicit per-item prices were not present in the provided text extract
--   or would require an excessive number of inserts. You can extend this table using the same pattern for variants (e.g., glass/bottle).
-- • Dietary tag legend: v = vegetarian, vgn = vegan, gf = gluten free, df = dairy free, * = available on request.

-- Done.