#!groovy
pipeline {
    agent any
    stages {
        stage('Clean up') {
                    steps {
                        bat 'docker-compose down || true'
                    }
                }
        stage('Build') {
            steps {
                bat 'docker-compose up -d'
            }
        }
        post {
          always {
             bat "docker-compose down || true"
          }
        }
    }
}