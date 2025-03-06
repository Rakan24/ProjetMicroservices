# Étape 1 : Construire l'application
FROM maven:3.8.1-openjdk-17-slim AS build

# Définir le répertoire de travail
WORKDIR /app

# Copier le fichier pom.xml et télécharger les dépendances Maven
COPY pom.xml .

# Télécharger les dépendances
RUN mvn dependency:go-offline

# Copier tout le code source
COPY src ./src

# Construire l'application avec Maven (génère un fichier .jar)
RUN mvn clean package -DskipTests

# Étape 2 : Créer l'image finale
FROM openjdk:17-jdk-slim

# Définir le répertoire de travail
WORKDIR /app

# Copier le fichier .jar généré depuis l'étape précédente
COPY --from=build /app/target/commande-service.jar /app/commande-service.jar

# Exposer le port que l'application Spring Boot va utiliser
EXPOSE 8080

# Lancer l'application Spring Boot
CMD ["java", "-jar", "commande-service.jar"]
