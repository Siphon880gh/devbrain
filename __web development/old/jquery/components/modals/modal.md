
        <!-- Modal -->
        <div id="modal-presets" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Presets</h4>
                <small>
                </p>
                <p>All columns are optional. Comma-separated queries are searched using AND logic, followed by comma-separated exclusions which are searched using OR. The folder column limits which folders in the /logs directory is searched (affecting which option is checked under the folder options). More on the folders: If the folder column is empty or the folder name is misspelled, then the folders checked do not change. Folders can be spelled out partially. Do not provide multiple folder names because the folder column is meant to only receive one folder, unlike the Comma-separated columns that can receive multiple values.</p>
                </small>
              </div>
              <div class="modal-body">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Description</th>
                      <th>Folder</th>
                      <th>Comma-Separated Queries</th>
                      <th>Comma-Separated Exclusions</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php include("settings/presets.php"); ?>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>