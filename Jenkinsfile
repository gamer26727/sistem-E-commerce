pipeline {
    agent any
    stages {
        stage('Hello') {
            steps {
                echo 'My Jenkins Pipeline'
            }
        }
        stage('Check Docker') {
            steps {
                bat '"C:/Users/gamer/AppData/Local/Programs/DockerDesktop/resources/bin/docker.exe" version'
            }
        }
        stage('Build Docker Image') {
            steps {
                bat '"C:/Users/gamer/AppData/Local/Programs/DockerDesktop/resources/bin/docker.exe" build -t sistem-ecommerce:%BUILD_NUMBER% .'
            }
        }
    }
}
