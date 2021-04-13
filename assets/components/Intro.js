import React from "react";

const Intro = () => {
	return (
		<section className="intro">
			<div>
				<p>
					This page describes an unoffical api developed for IPL data
					and statistics for all players (as per now). As needed such
					data for one of the project and there was no suitable api
					found for the purpose, so decided to create one, and as it
					was created, shared too, if required by anybody.
					<br />
					The api is developed by scraping data from official website
					of{" "}
					<a href="https://www.iplt20.com">https://www.iplt20.com</a>,
					and is latest by the statistics available there. The data is{" "}
					<a href="https://www.iplt20.com">https://www.iplt20.com</a>{" "}
					property and all rights reserved with them.
				</p>
				<p className="intro-emp">
					{" "}
					Api docs are hosted using{" "}
					<a href="https://www.postman.com/">Postman</a> as it is
					convenient. Learn more about the actual api docs here:{" "}
					<a>To be uploaded</a>
				</p>
				<p className="intro-emp">
					Here you can visualize and play with the data.
				</p>
			</div>
		</section>
	);
};

export default Intro;