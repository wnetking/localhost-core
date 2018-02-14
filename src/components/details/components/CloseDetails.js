import { h, Component } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import { closeProjectInfo } from "../actions";

function CloseDetails({ closeProjectInfo }) {
  return (
    <button className="btn-close" type="button" onClick={closeProjectInfo}>
      x
    </button>
  );
}

const mapDispatchToProps = dispatch => ({
  closeProjectInfo: bindActionCreators(closeProjectInfo, dispatch)
});

export default connect(state => state, mapDispatchToProps)(CloseDetails);
