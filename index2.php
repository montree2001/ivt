<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Loading Bar</title>
<link rel="stylesheet" href="styles.css">
<style>
  body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.progress-bar {
  width: 80%;
  border: 1px solid #333;
  height: 30px;
}

.progress {
  background-color: #3498db;
  height: 100%;
  width: 0;
  transition: width 0.5s ease-in-out;
}

</style>

</head>
<body>
<div class="progress-bar">
  <div class="progress"></div>
</div>
<script>
    const progressBar = document.querySelector('.progress');
    
    let width = 0;
    const interval = setInterval(() => {
      if (width >= 100) {
        clearInterval(interval);
      } else {
        width++;
        progressBar.style.width = `${width}%`;
      }
    }, 50);
    
</script>
</body>
</html>
