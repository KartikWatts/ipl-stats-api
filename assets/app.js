import React from "react";
import ReactDOM from "react-dom";
import Footer from "./components/Footer";
import Intro from "./components/Intro";
import Navbar from "./components/Navbar";
import SelectionBar from "./containers/SelectionBar";

import "./styles/app.css";

const App = () => {
	return (
		<>
			<div className="page-container">
				<div className="content-wrap">
					<Navbar />
					<Intro />
					<SelectionBar />
				</div>
				<Footer />
			</div>
		</>
	);
};

ReactDOM.render(<App />, document.getElementById("root"));
