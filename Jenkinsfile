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
                bat 'docker version'
            }
        }
    }
}
