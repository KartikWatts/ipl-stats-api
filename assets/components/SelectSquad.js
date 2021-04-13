import React from "react";

const SelectSquad = ({ squad, img, name, onClick, selectedIndex }) => {
	let comp = (
		<div
			className={`squad-select squad-text ${
				selectedIndex === 0 ? "selected" : null
			}`}
			onClick={onClick}
		>
			{squad}
		</div>
	);
	if (squad !== "ALL") {
		comp = (
			<img
				className={`squad-select squad-img ${
					selectedIndex == squad ? "selected" : null
				}`}
				src={img}
				alt={name}
				onClick={onClick}
			/>
		);
	}

	return <>{comp}</>;
};

export default SelectSquad;
