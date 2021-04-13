import React from "react";

const Navbar = () => {
	return (
		<header>
			<nav className="nav">
				<div className="nav-main">
					<img src="https://www.iplt20.com/resources/v4.22.0/i/element-bgs/ipl-logo.svg"></img>
					<div className="nav-main-title">IPL T20 Stats API</div>
					<div className="nav-main-title__extras">[Unofficial]</div>
				</div>
				<div className="nav-options">
					<a className="link">
						<span className="not-on-mobile">View</span> Docs
					</a>
				</div>
			</nav>
		</header>
	);
};

export default Navbar;
