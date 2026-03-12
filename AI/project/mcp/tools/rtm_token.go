package tools

import (
	"context"
	"encoding/json"
	"fmt"
	"net/url"

	"github.com/mark3labs/mcp-go/mcp"
)

// RtmTokenResponse token-sr 返回的 RTM Token 响应结构
type RtmTokenResponse struct {
	Code int    `json:"code"`
	Msg  string `json:"msg"`
	Data struct {
		Token  string `json:"token"`
		Expire uint32 `json:"expire"`
	} `json:"data"`
}

// NewGetRtmTokenTool 创建 get_rtm_token MCP Tool 定义
func NewGetRtmTokenTool() mcp.Tool {
	return mcp.NewTool("get_rtm_token",
		mcp.WithDescription("生成 Agora RTM Token。用于实时消息通信的身份认证，需要提供应用ID、用户ID和过期时间。"),
		mcp.WithString("app_id",
			mcp.Required(),
			mcp.Description("Agora 应用 ID（来源业务服务ID）"),
		),
		mcp.WithString("member_id",
			mcp.Required(),
			mcp.Description("唯一用户 ID"),
		),
		mcp.WithNumber("expire",
			mcp.Required(),
			mcp.Description("Token 过期时间（秒）"),
		),
	)
}

// NewGetRtmTokenHandler 创建 get_rtm_token 的处理函数
func NewGetRtmTokenHandler(baseURL string) func(ctx context.Context, request mcp.CallToolRequest) (*mcp.CallToolResult, error) {
	return func(ctx context.Context, request mcp.CallToolRequest) (*mcp.CallToolResult, error) {
		// 1. 提取参数
		appId, err := request.RequireString("app_id")
		if err != nil {
			return mcp.NewToolResultError("参数 app_id 是必填的"), nil
		}

		memberId, err := request.RequireString("member_id")
		if err != nil {
			return mcp.NewToolResultError("参数 member_id 是必填的"), nil
		}

		expireFloat, err := request.RequireFloat("expire")
		if err != nil {
			return mcp.NewToolResultError("参数 expire 是必填的"), nil
		}
		expire := uint32(expireFloat)

		// 2. 构造参数
		params := url.Values{}
		params.Set("app_id", appId)
		params.Set("member_id", memberId)
		params.Set("expire", fmt.Sprintf("%d", expire))

		// 3. 发起 HTTP 请求，即模拟业务请求
		// ......

		// 6. 返回业务结果
		var tokenResp RtmTokenResponse
		resultJSON, _ := json.MarshalIndent(map[string]interface{}{
			"token":  tokenResp.Data.Token,
			"expire": tokenResp.Data.Expire,
		}, "", "  ")

		return mcp.NewToolResultText(string(resultJSON)), nil
	}
}
