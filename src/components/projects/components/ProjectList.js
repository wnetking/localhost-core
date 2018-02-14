import { h, Component } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import { getProjectList } from "../actions";
import { getFilterProject } from "../../filter/reducer";
import ProjectItem from "./ProjectItem";

class ProjectList extends Component {
  componentDidMount() {
    let { getProjectList } = this.props;

    getProjectList();
  }

  render() {
    let { fatching, data } = this.props;
    return (
      <div className="container">
        <div className="row">
          {!fatching ? data.map(item => <ProjectItem project={item} />) : ""}
        </div>
      </div>
    );
  }
}

const mapDispatchToProps = dispatch => ({
  getProjectList: bindActionCreators(getProjectList, dispatch)
});

export default connect(
  state =>
    state.projects.data !== null
      ? getFilterProject(state.projects, state.filter)
      : state.projects,
  mapDispatchToProps
)(ProjectList);
