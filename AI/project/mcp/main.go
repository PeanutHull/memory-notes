package main

import (
	"flag"
	"fmt"
	"os"

	"token_service/mcp/tools"

	"github.com/mark3labs/mcp-go/server"
)

func main() {
	baseURL := flag.String("base-url", "http://localhost:8888", "token-sr 服务的基础 URL")
	transport := flag.String("transport", "stdio", "传输方式: stdio 或 sse")
	addr := flag.String("addr", ":9090", "SSE 模式下的监听地址")
	flag.Parse()

	// 创建 MCP Server
	s := server.NewMCPServer(
		"token-sr-mcp",
		"1.0.0",
		server.WithToolCapabilities(false),
	)

	// 注册 get_rtm_token 工具
	s.AddTool(
		tools.NewGetRtmTokenTool(),
		tools.NewGetRtmTokenHandler(*baseURL),
	)

	// 根据传输方式启动
	switch *transport {
	case "stdio":
		fmt.Fprintln(os.Stderr, "Starting token-sr MCP Server (stdio mode)...")
		if err := server.ServeStdio(s); err != nil {
			fmt.Fprintf(os.Stderr, "Server error: %v\n", err)
			os.Exit(1)
		}
	case "sse":
		fmt.Fprintf(os.Stderr, "Starting token-sr MCP Server (SSE mode) on %s...\n", *addr)
		sseServer := server.NewSSEServer(s)
		if err := sseServer.Start(*addr); err != nil {
			fmt.Fprintf(os.Stderr, "Server error: %v\n", err)
			os.Exit(1)
		}
	default:
		fmt.Fprintf(os.Stderr, "未知的传输方式: %s (支持 stdio, sse)\n", *transport)
		os.Exit(1)
	}
}
