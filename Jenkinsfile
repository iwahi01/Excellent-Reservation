node('iwahi01-ta20') {
  notifyBuild('STARTED')
  checkout scm
  stage('ハウスキーピング') {
    parallel (
      'Seleniumサーバの削除': {
        try {
          sh 'docker stop selenium-docker'
          sh 'docker rm selenium-docker'
        } catch(error) {
        }
      },
      'Webサーバの削除': {
        try {
          sh 'docker stop selenium-httpd'
          sh 'docker rm selenium-httpd'
        } catch(error) {
        }
      }
    )
  }

  stage('サーバの起動') {
    parallel (
      'Seleniumサーバの起動': {
        try {
          sh 'docker run -d -p 4444:4444 --name selenium-docker selenium/standalone-chrome'
        } catch(error) {
          notifyBuild('FAILED')
          error 'Seleniumサーバの起動エラー'
        }
      },
      'Webサーバの起動': {
        try {
          sh 'docker build -t iwahi01/selenium-httpd .'
          sh 'docker run -d -p 5555:80 --name selenium-httpd iwahi01/selenium-httpd'
        } catch(error) {
          notifyBuild('FAILED')
          error 'Webサーバの起動エラー'
        }
      }
    )
  }

  stage ('PHPUnitテスト実行') {
    try {
      sh 'sleep 10'
      sh '/opt/vendor/bin/phpunit runSelenium.php'
    } catch(error) {
      notifyBuild('FAILED')
      error 'PHPUnitテスト実行エラー'
    } finally {
      parallel (
        'Seleniumサーバの削除': {
          sh 'docker stop selenium-docker'
          sh 'docker rm selenium-docker'
        },
        'Webサーバの削除': {
          sh 'docker stop selenium-httpd'
          sh 'docker rm selenium-httpd'
        }
      )
    }
  }

  stage ('CDDイテレーション2の起動') {
    try {
      sh 'php runCDD.php'
    } catch(error) {
      notifyBuild('FAILED')
      error 'CDDイテレーション2の起動エラー'
    }
  }

  notifyBuild('SUCCESSFUL')
}

//Slackメッセージ送信
def notifyBuild(String buildStatus = 'STARTED') {
  // build status of null means successful
  buildStatus =  buildStatus ?: 'SUCCESSFUL'
  // Default values
  def colorName = 'RED'
  def colorCode = '#FF0000'
  def subject = "${buildStatus}: ジョブ '${env.JOB_NAME} [${env.BUILD_NUMBER}]'"
  def summary = "${subject} (${env.BUILD_URL})"
  // Override default values based on build status
  if (buildStatus == 'STARTED') {
    color = 'YELLOW'
    colorCode = '#FFFF00'
  } else if (buildStatus == 'SUCCESSFUL') {
    color = 'GREEN'
    colorCode = '#00FF00'
  } else {
    color = 'RED'
    colorCode = '#FF0000'
  }
  // Send notifications
  slackSend (color: colorCode, message: summary)
}