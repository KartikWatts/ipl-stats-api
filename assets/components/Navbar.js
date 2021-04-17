import React from "react";
import git from "../images/git.png";

const Navbar = () => {
	return (
		<header>
			<nav className="nav">
				<div className="nav-main">
					<img
						alt="IPL"
						className="not-on-mobile"
						src="https://www.iplt20.com/resources/v4.22.0/i/element-bgs/ipl-logo.svg"
					></img>
					<div className="nav-main-title">IPL T20 Stats API</div>
					<div className="nav-main-title__extras">[Unofficial]</div>
				</div>
				<div className="nav-options">
					<a href="https://github.com/KartikWatts/ipl-stats-api">
						<img className="nav-options__img" alt="Git" src={git} />
					</a>
					<a
						className="link"
						href="https://documenter.getpostman.com/view/10557860/TzJsedV4"
					>
						<span className="not-on-mobile">View</span> Docs
					</a>
				</div>
			</nav>
		</header>
	);
};

export default Navbar;
