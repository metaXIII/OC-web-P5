#!groovy
pipeline {
    agent any
    stages {
        stage('Clean up') {
            steps {
                sh 'docker-compose down || true'
            }
        }
        stage('Build') {
            steps {
                sh 'docker-compose up -d'
            }
        }
    }
    post {
        always {
            sh "docker-compose down || true"
            }
        }
}
