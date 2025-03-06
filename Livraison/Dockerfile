# Étape 1 : Construire l'application
FROM maven:3.8.1-openjdk-17-slim AS build

WORKDIR /app

COPY pom.xml .
RUN mvn dependency:go-offline
COPY src ./src
RUN mvn clean package -DskipTests

# Étape 2 : Créer l'image finale
FROM openjdk:17-jdk-slim

WORKDIR /app
COPY --from=build /app/target/livraison-service.jar /app/livraison-service.jar

EXPOSE 8080
CMD ["java", "-jar", "livraison-service.jar"]
