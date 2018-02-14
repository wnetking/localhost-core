import { h, Component } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import BaseProjectInfo from "./BaseProjectInfo";
import ModuleList from "./ModuleList";
import Button from "./Button";
import CloseDetails from "./CloseDetails";
import { clearDbRequest, removeProject } from "../actions";

class Info extends Component {
  render() {
    let { details, clearDbRequest, removeProject } = this.props;
    return (
      <div
        className="project-info"
        style={{ display: details.show ? "block" : "none" }}
      >
        {!details.fatching ? (
          <div>
            <CloseDetails />
            <h2>{`Project Info`}</h2>
            <BaseProjectInfo data={details.data} />
            <ModuleList data={details.data.modules} />
            <div>
              {details.type !== "other" && details.data ? (
                <Button
                  onClick={clearDbRequest.bind(
                    null,
                    details.projectName,
                    details.type
                  )}
                >
                  Clear data base
                </Button>
              ) : (
                ""
              )}
              <Button
                onClick={removeProject.bind(
                  null,
                  details.projectName,
                  details.type
                )}
              >
                Remove Project
              </Button>
              <p>
                {details.message ? details.message : ""}
                {details.makeRequest ? "Loading ..." : ""}
              </p>
            </div>
          </div>
        ) : (
          "Loading.."
        )}
      </div>
    );
  }
}

const mapDispatchToProps = dispatch => ({
  clearDbRequest: bindActionCreators(clearDbRequest, dispatch),
  removeProject: bindActionCreators(removeProject, dispatch)
});

export default connect(state => state, mapDispatchToProps)(Info);
