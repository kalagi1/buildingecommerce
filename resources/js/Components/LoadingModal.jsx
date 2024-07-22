import React, { useState, useEffect } from "react";
import { Modal, Box, LinearProgress, Typography } from "@mui/material";

const LoadingModal = ({ open, progress }) => (
  <Modal open={open}>
    <Box
      sx={{
        width: "50%",
        margin: "auto",
        marginTop: "20%",
        padding: "20px",
        backgroundColor: "white",
        textAlign: "center",
      }}
    >
      <h2>İlanınız oluşturuluyor</h2>
      <p>
        Lütfen işlem tamamlanana kadar tarayıcıyı ve bilgisayarı kapatmayın.
      </p>
      <LinearProgress variant="determinate" value={progress} />
    </Box>
  </Modal>
);

export default LoadingModal;
