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
					<a target="_blank" href="https://www.iplt20.com">
						https://www.iplt20.com
					</a>
					, and is latest by the statistics available there. The data
					is{" "}
					<a target="_blank" href="https://www.iplt20.com">
						https://www.iplt20.com
					</a>{" "}
					property and all rights reserved with them.
				</p>
				<p className="intro-emp">
					{" "}
					Api docs are hosted with Postman. Learn more about the
					actual api docs here:{" "}
					<a href="https://documenter.getpostman.com/view/10557860/TzJsedV4">
						Docs Link
					</a>
				</p>
				<p className="intro-emp">
					Here you can visualize and the data by selecting and sorting
					as desired (every combination of record is possible in the
					table below).
					<span className="only-on-mobile">
						You can rotate the mobile to landscape for better view.
					</span>
				</p>
			</div>
		</section>
	);
};

export default Intro;
