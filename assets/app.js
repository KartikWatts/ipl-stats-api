import React from "react";
import ReactDOM from "react-dom";
import Intro from "./components/Intro";
import Navbar from "./components/Navbar";
import SelectionBar from "./containers/SelectionBar";

import "./styles/app.css";

const App = () => {
	return (
		<>
			<Navbar />
			<Intro />
			<SelectionBar />
		</>
	);
};

ReactDOM.render(<App />, document.getElementById("root"));
