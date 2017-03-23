-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Users(
    id SERIAL PRIMARY KEY,
    username varchar(50) NOT NULL,
    password varchar(50) NOT NULL
);

CREATE TABLE Note(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES Users(id),
    header varchar(50),
    text varchar(1000)
);

CREATE TABLE List(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES Users(id),
    header varchar(50)
);

CREATE TABLE Listitem(
    id SERIAL PRIMARY KEY,
    list_id INTEGER REFERENCES List(id),
    text varchar(300),
    done boolean DEFAULT FALSE 
);