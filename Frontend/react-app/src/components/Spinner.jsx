import React from "react";

function Spinner() {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="250"
      height="250"
      display="block"
      preserveAspectRatio="xMidYMid"
      viewBox="0 0 100 100"
      style={{}}
    >
      <g transform="translate(50 50) scale(.7) translate(-50 -50)">
        <animateTransform
          attributeName="transform"
          dur="0.7575757575757576s"
          keyTimes="0;1"
          repeatCount="indefinite"
          type="rotate"
          values="0 50 50;360 50 50"
        ></animateTransform>
        <path
          fill="#3c3c3c"
          fillOpacity="0.8"
          d="M50 50V0a50 50 0 0150 50z"
        ></path>
      </g>
      <g transform="translate(50 50) scale(.7) translate(-50 -50)">
        <animateTransform
          attributeName="transform"
          dur="1.0101010101010102s"
          keyTimes="0;1"
          repeatCount="indefinite"
          type="rotate"
          values="0 50 50;360 50 50"
        ></animateTransform>
        <path
          fill="#838383"
          fillOpacity="0.8"
          d="M50 50h50a50 50 0 01-50 50z"
        ></path>
      </g>
      <g transform="translate(50 50) scale(.7) translate(-50 -50)">
        <animateTransform
          attributeName="transform"
          dur="1.5151515151515151s"
          keyTimes="0;1"
          repeatCount="indefinite"
          type="rotate"
          values="0 50 50;360 50 50"
        ></animateTransform>
        <path
          fill="#c2c2c2"
          fillOpacity="0.8"
          d="M50 50v50A50 50 0 010 50z"
        ></path>
      </g>
      <g transform="translate(50 50) scale(.7) translate(-50 -50)">
        <animateTransform
          attributeName="transform"
          dur="3.0303030303030303s"
          keyTimes="0;1"
          repeatCount="indefinite"
          type="rotate"
          values="0 50 50;360 50 50"
        ></animateTransform>
        <path
          fill="#f0f0f0"
          fillOpacity="0.8"
          d="M50 50H0A50 50 0 0150 0z"
        ></path>
      </g>
    </svg>
  );
}

export default Spinner;
