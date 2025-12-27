import TextField from "@mui/material/TextField";
import Box from "@mui/material/Box";

export default function WorkflowMessageFieldComponent({
    value,
    onChange,
    error = false,
    helperText = "",
}) {
    return (
        <Box sx={{ mt: 2 }}>
            <TextField
                label="Workflow Message"
                placeholder="Write your remarks here..."
                multiline
                rows={3}
                fullWidth
                required
                value={value}
                onChange={onChange}
                error={error}
                helperText={
                    helperText ||
                    "This message will be saved in workflow history"
                }
            />
        </Box>
    );
}
