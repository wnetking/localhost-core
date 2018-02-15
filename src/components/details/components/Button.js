import { h, Component } from "preact";

function Button({ data, onClick, children }) {
  return (
    <button className="btn" type="button" onClick={onClick}>
      {children}
    </button>
  );
}

export default Button;
