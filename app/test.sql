CREATE TABLE Client (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Telefon VARCHAR(20),
    Email VARCHAR(100),
    Tip ENUM('Persoana fizica', 'Persoana juridica'),
    Nume VARCHAR(100),
    Prenume VARCHAR(100),
    Serie_Buletin VARCHAR(10) NULL
);

CREATE TABLE Camera (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Numar_camera VARCHAR(10) NOT NULL,
    Tip INT,
    FOREIGN KEY (Tip) REFERENCES Tip_camera(ID) ON DELETE CASCADE
);

CREATE TABLE Tip_camera (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nume VARCHAR(50) NOT NULL,
    Capacitate INT CHECK (Capacitate > 0)
);

CREATE TABLE Rezervare (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_Client INT,
    ID_Camera INT,
    Data_inceput DATE NOT NULL,
    Durata INT CHECK (Durata > 0),
    Observatii TEXT,
    FOREIGN KEY (ID_Client) REFERENCES Client(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Camera) REFERENCES Camera(ID) ON DELETE CASCADE
);

CREATE TABLE Tarif (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Tip_camera INT,
    Data_inceput DATE NOT NULL,
    Data_end DATE NOT NULL,
    Pret INT NOT NULL,
    FOREIGN KEY (Tip_camera) REFERENCES Tip_camera(ID) ON DELETE CASCADE
);

Insert into Client  (Telefon, Email, Tip, Nume, Prenume, CNP, Serie_Buletin) values ('0740123456', 'AndreiMariaAndreea@magilk.com', 'Persoana fizica', 'Andrei', 'Maria Andreea', 'SY902101');
Insert into Client  (Telefon, Email, Tip, Nume, Prenume, CNP, Serie_Buletin) values ('0792345600', 'IaKaMa@hooyas.com', 'Persoana fizica', 'Iancu', 'Karina Marina', 'NJ234171');
Insert into Client  (Telefon, Email, Tip, Nume, Prenume, CNP, Serie_Buletin) values ('0785426942', 'IonescuSteinNaucitorul@gooool.kom', 'Persoana fizica', 'IonescuStein', 'Ion Ionnica', 'MG694269');
Insert into Client  (Telefon, Email, Tip, Nume, Prenume, CNP, Serie_Buletin) values ('0244321022', 'Kamille@blogCelebru.www', 'Persoana juridica', 'Kamilla', 'Blog', 'Ro993921');
