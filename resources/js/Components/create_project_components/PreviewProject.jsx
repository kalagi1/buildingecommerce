import React, { useEffect, useState } from "react";
import Modal from "@mui/material/Modal";
import Box from "@mui/material/Box";
import CircularProgress from "@mui/material/CircularProgress";
import axios from "axios";

function PreviewProject({
  createProject,
  projectData,
  haveBlocks,
  setProjectDataFunc,
  allErrors,
  finishCreateProject,
  fillFormData,
  prevStep,
  totalRoomCount,
  roomCount,
  blocks,
  selectedTypes
}) {
  const [open, setOpen] = useState(false);
  const [loading, setLoading] = useState(true);
  const [htmlContent, setHtmlContent] = useState("");
  const style = {
    position: "absolute",
    top: "50%",
    left: "50%",
    transform: "translate(-50%, -50%)",
    width: "70%",
    maxHeight: "70vh",
    bgcolor: "background.paper",
    boxShadow: 24,
    p: 4,
  };

  const fetchPreview = async () => {
    try {
      const response = await axios.post("/preview-project", {
        fillFormData,
        projectData,
        selectedTypes,
        blocks,
        totalRoomCount,
        haveBlocks,
        roomCount
      });
      setHtmlContent(response.data);
    } catch (error) {
      console.error("Error fetching preview:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    console.log(fillFormData);
    fetchPreview();
  }, []);

  return (
    <div>
      <div className="mb-5">
        <div>
          <h2 className="mt-5 text-center">
            İlanınızla ilgili aşağıdaki bilgiler doğruysa "Devam Et" butonunu
            tıklayıp bir sonraki aşamaya geçin.
          </h2>
        </div>
        <div
          className="second-area-finish"
          style={{ justifyContent: "center" }}
        >
          <div
            className="finish-button"
            style={{ float: "left", marginRight: "10px" }}
          >
            <button
              onClick={prevStep}
              style={{
                backgroundColor: "#274abb",
                display: "inline-block",
                fontWeight: "400",
                color: "white",
                textAlign: "center",
                verticalAlign: "middle",
                border: "1px solid transparent",
                padding: ".375rem .91rem",
                fontSize: "11px",
                width: "110%"
              }}
            >
              Düzenle
            </button>
          </div>
          <div
            className="finish-button"
            style={{ float: "right", marginLeft: "10px" }}
          >
            <button onClick={finishCreateProject} className="btn btn-info">
              Devam Et
            </button>
          </div>
        </div>
      </div>
      {loading ? (
        <div style={{ textAlign: "center", marginTop: "20px" }}>
          <CircularProgress />
          <p>Önizleme yükleniyor...</p>
        </div>
      ) : (
        <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
      )}
      <Modal
        open={open}
        onClose={() => {
          setOpen(false);
        }}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
      >
        <Box sx={style}>
          <h2>İlan Verme Kuralları</h2>
        </Box>
      </Modal>
    </div>
  );
}

export default PreviewProject;
