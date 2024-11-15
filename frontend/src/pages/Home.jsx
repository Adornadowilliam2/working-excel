import { DataGrid } from "@mui/x-data-grid";
import React, { useEffect, useState } from "react";
import { destroy, index, store, update } from "../api/product";
import { toast } from "react-toastify";
import { Box, Button, Dialog, DialogActions, DialogContent, DialogTitle, TextField, Typography } from "@mui/material";
import $ from "jquery";

export default function Home() {
    const [editDialog, setEditDialog] = useState(null);
    const [deleteDialog, setDeleteDialog] = useState(null);
    const [createDialog, setCreateDialog] = useState(false);

    const columns = [
        { field: "id", headerName: "ID" },
        { field: "link", headerName: "Link", flex:1 },
        { field: "content", headerName: "Content" ,flex:1},
        { field: "remarks", headerName: "Remarks",flex:1 },
        { field: "views", headerName: "Views", flex:1 },
        { field: "like", headerName: "Like",flex:1},
        { field: "link_clicked", headerName: "Link Clicked", flex:1 },
        { field: "share", headerName: "Share" , flex:1},
        { field: "save", headerName: "Save" ,flex:1},
        {
            field: "actions",
            headerName: "",
            sortable: false,
            filterable: false,
            renderCell: (params) => (
                <Box
                    sx={{
                        display: "flex",
                        gap: 1,
                        justifyContent: "center",
                        alignItems: "center",
                        height: "100%",
                    }}
                >
                    <Button
                        variant="contained"
                        color="warning"
                        onClick={() => setEditDialog({ ...params.row })}
                    >
                        Edit
                    </Button>
                    <Button
                        variant="contained"
                        color="error"
                        onClick={() => setDeleteDialog(params.row.id)}
                    >
                        Delete
                    </Button>
                </Box>
            ),
            width: 200,
        },
    ];
    const [rows, setRows] = useState([]);

    const refreshData = () => {
        index().then((res) => {
            if (res?.ok) {
                setRows(res.data);
            } else {
                toast.error(res?.message ?? "Something went wrong.");
            }
        });
    };
    useEffect(()=>{
        refreshData();
    }, []);

    const onEdit = (e) => {
        e.preventDefault();
        update(
            {   
                id: editDialog.id,
                link: editDialog.link,
                content: editDialog.content,
                remarks: editDialog.remarks,
                views: editDialog.views,
                comment: editDialog.comment,
                like: editDialog.like,
                link_clicked: editDialog.link_clicked,
                share: editDialog.share,
                save: editDialog.save
            }
        ).then((res)=>{
            if(res?.ok){
                toast.success(res?.message ?? "Update Successfully");
                setEditDialog(null);
                refreshData();
            }else{
                toast.error(res?.message ?? "Something went wrong.");
            }
        })
    }

    const onCreate = (e) => {
        e.preventDefault();
        const body = {
            link: $("#link").val(),
            content: $("#content").val(),
            remarks: $("#remarks").val(),
            views: $("#views").val(),
            comment: $("#comment").val(),
            like: $("#like").val(),
            link_clicked: $("#link_clicked").val(),
            share: $("#share").val(),
            save: $("#save").val(),
        };

        store(body)
            .then((res) => {
                console.log(res)
                if (res?.ok) {
                    toast.success(res?.message ?? "Created Successfully");
                    setCreateDialog(false);
                    refreshData();
                } else {
                    toast.error(res?.message ?? "Something went wrong.");
                }
        })

    };
    const onDelete = (e) => {
        e.preventDefault()
        destroy(deleteDialog)
            .then((res) => {
                toast.success(res?.message ?? "Something went wrong.");
                refreshData();
                setDeleteDialog(null)
        })
    };

    return (
        <main>
            <Button
                onClick={() => setCreateDialog(true)}
                variant="contained"
                color="info"
                sx={{mt:1, mb:1}}
            >
            Create 
            </Button>
            <DataGrid rows={rows} columns={columns}/>
            <Dialog open={!!createDialog}>
                <DialogTitle>Create Form</DialogTitle>
                <DialogContent>
                    <Box component="form" onSubmit={onCreate}>
                        <Box>
                            <TextField
                                id="link"
                                label="Link"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="content"
                                label="Content"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="remarks"
                                label="Remarks"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="views"
                                label="Views"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                                type="number"
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="comment"
                                label="Comment"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="like"
                                label="Like"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="link_clicked"
                                label="Link Clicked"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="share"
                                label="Share"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box>
                            <TextField
                                id="save"
                                label="Save"
                                variant="outlined"
                                margin="normal"
                                fullWidth
                                required
                            />
                        </Box>
                        <Box className="d-flex justify-content-center align-items-center">
                            <Button
                                color="info"
                                variant="contained"
                                sx={{mr: 1}}
                                onClick={() => setCreateDialog(false)}
                            >
                                Close
                            </Button>
                            <Button
                                id="btn"
                                type="submit"
                                variant="contained"
                                color="success"
                            >
                                Submit
                            </Button>
                        </Box>
                    </Box>
                </DialogContent>
            </Dialog>
            
            {/* Delete */}
            <Dialog open={!!deleteDialog}>
                <DialogTitle>Are you sure?</DialogTitle>
                <DialogContent>
                    <Typography>
                        Do you want to delete this ID: {deleteDialog}
                    </Typography>
                </DialogContent>
                <DialogActions
                    sx={{
                        display: !!deleteDialog ? "flex" : "none",
                    }}
                >
                    <Button onClick={() => setDeleteDialog(null)} color="info" variant="contained">
                        Cancel
                    </Button>
                    <Button onClick={onDelete} variant="contained" color="error">
                        Confirm
                    </Button>
                </DialogActions>
            </Dialog>

            {/* Edit  */}
            <Dialog open={!!editDialog}>
                <DialogTitle>Edit</DialogTitle>
                <DialogContent>
                    <Box component="form" sx={{ p: 1 }} onSubmit={onEdit}>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    link: e.target.value,
                                })
                            }
                                value={editDialog?.link ?? ""}
                                size="small"
                                label="Link"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    content: e.target.value,
                                })
                            }
                                value={editDialog?.content ?? ""}
                                size="small"
                                label="Content"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    remarks: e.target.value,
                                })
                            }
                                value={editDialog?.remarks ?? ""}
                                size="small"
                                label="Remarks"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    views: e.target.value,
                                })
                            }
                                value={editDialog?.views ?? ""}
                                size="small"
                                label="Views"
                                type="number"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    comment: e.target.value,
                                })
                            }
                                value={editDialog?.comment ?? ""}
                                size="small"
                                label="Comment"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    like: e.target.value,
                                })
                            }
                                value={editDialog?.like ?? ""}
                                size="small"
                                label="Like"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    link_clicked: e.target.value,
                                })
                            }
                                value={editDialog?.link_clicked ?? ""}
                                size="small"
                                label="Link Clicked"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    share: e.target.value,
                                })
                            }
                                value={editDialog?.share ?? ""}
                                size="small"
                                label="Share"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Box sx={{ mt: 1 }}>
                            <TextField
                              onChange={(e) =>
                                setEditDialog({
                                    ...editDialog,
                                    save: e.target.value,
                                })
                            }
                                value={editDialog?.save ?? ""}
                                size="small"
                                label="Save"
                                type="text"
                                fullWidth
                            />
                        </Box>
                        <Button
                            id="btn-confirm"
                            type="submit"
                            sx={{ display: "none" }}
                        >
                            Submit
                        </Button>
                    </Box>
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => setEditDialog(null)} variant="contained" color="info">
                        Cancel
                    </Button>
                    <Button
                        onClick={() => {
                            $("#btn-confirm").trigger("click");
                        }}
                        variant="contained"
                        color="warning"
                    >
                        Update
                    </Button>
                </DialogActions>
            </Dialog>
        </main>
    );
}
