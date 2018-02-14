import { h } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import { setVisibilityFilter } from "../actions";

function FilterLink({ type, setVisibilityFilter, children, filter }) {
  if (type === filter) {
    return <span className="btn disable">{children}</span>;
  }
  return (
    <button
      className="btn"
      type="button"
      onClick={setVisibilityFilter.bind(null, type)}
    >
      {children}
    </button>
  );
}

const mapDispatchToProps = dispatch => ({
  setVisibilityFilter: bindActionCreators(setVisibilityFilter, dispatch)
});

export default connect(state => state, mapDispatchToProps)(FilterLink);
