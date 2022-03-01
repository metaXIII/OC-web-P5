#!groovy
pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                bat 'docker-compose up -d'
            }
        }
    }
}