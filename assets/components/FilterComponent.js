import React from "react";
import {
	CheckBox,
	CheckBoxBar,
	CheckBoxLabel,
	CheckBoxWrapper,
	ClearButton,
	FilterBar,
	SearchBar,
	TextField,
} from "./UIComponents";

const FilterComponent = ({ filterText, onFilter, onClear, handleExpand }) => (
	<FilterBar>
		<SearchBar>
			<TextField
				id="search"
				type="text"
				autoComplete="off"
				placeholder="Search by Name"
				aria-label="Search Input"
				value={filterText}
				onChange={onFilter}
			/>
			<ClearButton type="button" onClick={onClear}>
				X
			</ClearButton>
		</SearchBar>
		<CheckBoxBar>
			<div> Show cards on row click: </div>
			<CheckBoxWrapper onChange={handleExpand}>
				<CheckBox id="checkbox" type="checkbox" />
				<CheckBoxLabel htmlFor="checkbox" />
			</CheckBoxWrapper>
		</CheckBoxBar>
	</FilterBar>
);

export default FilterComponent;
