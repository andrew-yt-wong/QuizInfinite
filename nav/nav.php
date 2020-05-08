<div id="header">
	<nav class="navbar navbar-expand-md navbar-dark">
		<a class="navbar-brand" id="logo" href="index.php">QuizInfinite</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto mynavbar">
				<li id="homepage" class="nav-item">
					<a class="nav-link" href="home.php">Home</a>
				</li>
				<?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) { ?>
				<?php } else { ?>
					<li id="quizpage" class="nav-item">
						<a class="nav-link" href="quiz_studio.php">Quiz Studio</a>
					</li>
				<?php } ?>
				<li class="nav-item">
					<a class="nav-link" href="https://github.com/andrew-yt-wong/QuizInfinite">GitHub</a>
				</li>
				<?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) { ?>
					<li id="loginpage" class="nav-item">
						<a class="nav-link" href="login-signup.php">Login / Signup</a>
					</li>
				<?php } else { ?>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
</div>