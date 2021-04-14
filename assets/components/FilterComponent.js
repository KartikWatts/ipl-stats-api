import React from "react";
import { ClearButton, FilterBar, SearchBar, TextField } from "./UIComponents";

const FilterComponent = ({ filterText, onFilter, onClear }) => (
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
		{/* <CheckBoxBar>
			<div> Show balling stats first</div>
			<CheckBoxWrapper onChange={onOrderChange}>
				<CheckBox id="checkbox" type="checkbox" />
				<CheckBoxLabel htmlFor="checkbox" />
			</CheckBoxWrapper>
		</CheckBoxBar> */}
	</FilterBar>
);

export default FilterComponent;
