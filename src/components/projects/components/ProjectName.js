import { h } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import { getProjectInfo } from "../actions";

function ProjectName({ name, type, getProjectInfo }) {
  return (
    <button className="h5" onClick={getProjectInfo.bind(null, name, type)}>
      {name}
    </button>
  );
}

const mapDispatchToProps = dispatch => ({
  getProjectInfo: bindActionCreators(getProjectInfo, dispatch)
});

export default connect(state => state, mapDispatchToProps)(ProjectName);
