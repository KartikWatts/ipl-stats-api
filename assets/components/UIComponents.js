import styled from "styled-components";

export const TextField = styled.input`
	height: 32px;
	width: 200px;
	border-radius: 3px;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	border-top-right-radius: 0;
	border-bottom-right-radius: 0;
	border: 2px solid #e5e5e5;
	padding: 0 32px 0 16px;
	display: inline-block;
`;

export const ClearButton = styled.div`
	border-top-left-radius: 0;
	border-bottom-left-radius: 0;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
	height: 32px;
	width: 50px;
	background: gray;
	text-align: center;
	display: flex;
	justify-content: center;
	align-items: center;
	position: relative;
	cursor: pointer;
	transition: all 0.2s;

	&:hover {
		transform: scale(1.1);
		background: #ff6f0f;
		color: white;
		font-weight: bold;
	}
`;

export const FilterBar = styled.div`
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 0.8rem;
	gap: 5rem;

	@media only screen and (max-width: 600px) {
		flex-direction: column;
		gap: 0.5rem;
	}
`;

export const SearchBar = styled.div`
	display: flex;
	justify-content: center;
	align-items: center;
`;

export const CheckBoxWrapper = styled.div`
	position: relative;
`;

export const CheckBoxLabel = styled.label`
	position: absolute;
	top: 0;
	left: 0;
	width: 42px;
	height: 26px;
	border-radius: 15px;
	background: #bebebe;
	cursor: pointer;
	&::after {
		content: "";
		display: block;
		border-radius: 50%;
		width: 18px;
		height: 18px;
		margin: 3px;
		background: #ffffff;
		box-shadow: 1px 3px 3px 1px rgba(0, 0, 0, 0.2);
		transition: 0.2s;
	}
`;

export const CheckBox = styled.input`
	opacity: 0;
	z-index: 1;
	border-radius: 15px;
	width: 42px;
	height: 26px;
	&:checked + ${CheckBoxLabel} {
		background: #4d82ff;
		&::after {
			content: "";
			display: block;
			border-radius: 50%;
			width: 18px;
			height: 18px;
			margin-left: 21px;
			transition: 0.2s;
		}
	}
`;

export const CheckBoxBar = styled.div`
	display: flex;
	justify-content: center;
	align-items: center;
	gap: 0.5rem;
`;
